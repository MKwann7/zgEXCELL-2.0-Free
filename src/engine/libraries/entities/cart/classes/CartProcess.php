<?php

namespace Entities\Cart\Classes;

use App\Core\App;
use App\Utilities\Excell\ExcellCollection;
use Entities\Cart\Classes\Helpers\CartMinimumValue;
use Entities\Cart\Classes\Helpers\CartStripeCheckout;
use Entities\Cart\Classes\Helpers\PackageSearch;
use Entities\Orders\Classes\OrderLines;
use Entities\Orders\Classes\Orders;
use Entities\Packages\Classes\Packages;
use Entities\Packages\Models\PackageLineModel;
use Entities\Packages\Models\PackageModel;
use Entities\Payments\Classes\ArInvoices;
use Entities\Payments\Classes\PaymentAccounts;
use Entities\Payments\Classes\Transactions;
use Entities\Payments\Classes\UserPaymentProperty;
use Entities\Payments\Models\ArInvoiceModel;
use Entities\Payments\Models\TransactionModel;
use Entities\Orders\Models\OrderLineModel;
use Entities\Orders\Models\OrderModel;

class CartProcess
{
    protected int $userId;
    protected $paymentAccountId;
    protected $packages;
    protected int $companyId;
    protected $defaultUserId;
    protected $stripeAccountType;
    protected $stripeAccountId;
    protected $grossCartValue;
    protected $grossProductsValue;
    protected float $processingFee;
    protected float $totalCartValue;
    protected float $totalProductsValue;
    protected $netToGrossPercentage = 0;
    protected $promoToTotalPercentage = 1;
    protected $promoCode = null;
    protected $paymentMethodId = null;
    /** @var CartProcessTransaction $transactionResult */
    protected $order = null;
    protected $arInvoice = null;
    protected $transactionResult = null;
    protected $app;
    protected $env;
    protected $errors;
    protected $disableProcessing = false;
    protected $packageSearch;

    public function __construct(array $arPackageIds, int $userId, int $paymentAccountId, App $app)
    {
        $this->transactionResult = new CartProcessTransaction();
        $this->errors = new ExcellCollection();
        $this->packageSearch = new PackageSearch();

        $this->packages = $this->loadPackagesFromIds($arPackageIds);

        $this->userId = $userId;
        $this->paymentAccountId = $paymentAccountId;
        $this->app = $app;
        $this->env = env("APP_ENV") === "production" ? "prod" : "test";
        $this->companyId = $this->app->objCustomPlatform->getCompanyId();
        $this->defaultUserId = $this->app->objCustomPlatform->getCompany()->default_sponsor_id ?? 1000;

        $stripeAccountType = $this->app->objCustomPlatform->getCompanySettings()->FindEntityByValue("label", "stripe_account_type");
        $this->stripeAccountType = $stripeAccountType->value ?? "customer";
        $this->stripeAccountId = $this->getCustomerStripeAccountId(1);

        if ($this->paymentAccountId !== 0) {
            $this->paymentMethodId = PaymentAccounts::getToken($this->paymentAccountId);
        }
    }

    public function processCheckout() : CartProcessTransaction
    {
        $this->processPackageLinesAndCreateTransactions();
        $this->processPromoCodeIfApplicable();
        $this->processProcessingFee();

        if ($this->totalCartValue <= 0) {
            $this->disableProcessing = true;
        }

        if ($this->disableProcessing !== true && $this->paymentAccountId === 0) {
            $this->errors->Add("A payment account is required for this purchase.");
            return $this->processTransactionReturn();
        }

        $stripeCheckout = new CartStripeCheckout(
            $this->totalCartValue,
            $this->totalProductsValue,
            $this->processingFee,
            $this->stripeAccountId,
            $this->paymentMethodId,
            $this->transactionResult
        );

        if($this->disableProcessing === false && !$stripeCheckout->process())
        {
            $this->errors->Merge($stripeCheckout->getErrors());
            return $this->processTransactionReturn();
        }

        if(!$this->createArInvoice())
        {
            return $this->processTransactionReturn();
        }

        if(!$this->createOrderAndOrderLinesForCart())
        {
            return $this->processTransactionReturn();
        }

        if(!$this->savePackageLineTransactions())
        {
            return $this->processTransactionReturn();
        }

        $this->transactionResult->getTransaction()->result->Success = true;
        $this->transactionResult->getTransaction()->result->Message = "Order processed successfully";

        return $this->processTransactionReturn();
    }

    private function loadPackagesFromIds($packageIds) : ExcellCollection
    {
        $packageQuantities = [];

        foreach($packageIds as $currPackage)
        {
            $arPackageIds[] = $currPackage["id"];
            $packageQuantities[$currPackage["id"]] = (float) $currPackage["quantity"];
        }

        $packages = Packages::getFullPackagesByIds("package_id", $arPackageIds)->getData();

        $CartMinValue = new CartMinimumValue();
        $CartMinValue->process($packages, $packageQuantities);

        return $packages;
    }

    public function processPromoCode($promoCode) : void
    {
        $objPromoCodes   = new PromoCodes();
        $promoCodeResult = $objPromoCodes->getById($promoCode);

        if ($promoCodeResult->result->Count === 1)
        {
            $this->promoCode = $promoCodeResult->getData()->first();
            $this->transactionResult->promoCode = $this->promoCode;
        }
    }

    private function createArInvoice() : bool
    {
        $objArInvoices = new ArInvoices();

        $arInvoice = new ArInvoiceModel();
        $arInvoice->company_id = $this->companyId;
        $arInvoice->division_id = 0;
        $arInvoice->user_id = $this->userId;
        $arInvoice->gross_value = $this->totalProcessingValue();
        //$arInvoice->net_value = $purchasePrice;
        $arInvoice->tax = 0;
        $arInvoice->payment_account_id = $this->paymentAccountId;
        $arInvoice->payment_type_id = 1; // stripe
        $arInvoice->status = "completed";

        $arInvoiceResult = $objArInvoices->createNew($arInvoice);

        if ($arInvoiceResult->result->Success === false)
        {
            $this->errors->Add("ArInvoice unable to be processed: " . $arInvoiceResult->result->Message);
            return false;
        }

        $this->arInvoice = $arInvoiceResult->getData()->first();

        return true;
    }

    private function createOrderAndOrderLinesForCart(): bool
    {
        $objOrders = new Orders();

        $order = new OrderModel();
        $order->company_id = $this->companyId;
        $order->division_id = 0;
        $order->user_id = $this->userId;
        $order->total_price = $this->totalCartValue;
        $order->title = "Cart Purchase on " . date("Y-m-d") . " at " . date("H:i:s");
        $order->status = "started"; // TODO - Question for Cheryl

        $orderResult = $objOrders->createNew($order);

        if ($orderResult->result->Success === false)
        {
            $this->errors->Add("Order unable to be processed: " . $orderResult->result->Message);
            return false;
        }

        $this->order = $orderResult->getData()->first();

        return $this->createOrderLinesForCart();
    }

    private function createOrderLinesForCart() : bool
    {
        if (empty($this->order))
        {
            $this->errors->Add("Order wasn't created successfully. Unable to create order lines.");
            return false;
        }

        $noErrors = true;
        $objOrderLines = new OrderLines();

        $this->loopThroughPackageLines(function(PackageLineModel $currPackageLine, PackageModel $currPackage) use ($objOrderLines, &$noErrors)
        {
            $currPackageLine->entities->Foreach(function(CartProductCapsule $cartProductCapsule) use ($objOrderLines, &$noErrors, $currPackageLine)
            {
                $product = $cartProductCapsule->getProduct();
                $orderLine = new OrderLineModel();

                $orderLine->order_id = $this->order->order_id;
                $orderLine->product_id = $currPackageLine->product->product_id;
                $orderLine->company_id = $this->companyId;
                $orderLine->user_id = $this->userId;
                $orderLine->payment_account_id = $this->paymentAccountId;
                $orderLine->title = $currPackageLine->product->display_name;
                $orderLine->status = "started";
                $orderLine->billing_date = date("Y-m-d H:i:s");

                if ($this->stripeAccountType === "connected")
                {
                    $orderLine->promo_price = $currPackageLine->promo_price;
                    $orderLine->promo_fee = $currPackageLine->product_promo_price_override ?? $product->promo_value;
                    $orderLine->price = $currPackageLine->regular_price;
                    $orderLine->price_fee = $currPackageLine->product_price_override ?? $product->value;
                }
                else
                {
                    $orderLine->promo_price = $currPackageLine->promo_price;
                    $orderLine->promo_fee = 0;
                    $orderLine->price = $currPackageLine->regular_price;
                    $orderLine->price_fee = 0;
                }

                $orderLine->promo_duration = $product->promo_cycle_duration;
                $orderLine->price_duration = $product->value_duration;
                $orderLine->cycle_type = $product->cycle_type;
                $orderLine->created_by = $this->defaultUserId;
                $orderLine->updated_by = $this->defaultUserId;

                $orderLineResult = $objOrderLines->createNew($orderLine);

                if ($orderLineResult->result->Success === false)
                {
                    $this->errors->Add("Order line unable to be processed: " . $orderLineResult->result->Message);
                    $noErrors = false;
                    return;
                }

                $cartProductCapsule->setOrderLine($orderLineResult->getData()->first());

                return $cartProductCapsule;
            });

            return $currPackageLine;
        });

        return $noErrors;
    }

    private function savePackageLineTransactions() : bool
    {
        $transactions = new Transactions();
        $this->loopThroughPackageLines(function(PackageLineModel $currPackageLine, PackageModel $currPackage) use ($transactions)
        {
            $currPackageLine->entities->Foreach(function(CartProductCapsule $cartProductCapsule) use ($transactions)
            {
                $transaction = $cartProductCapsule->getTransaction();
                $orderLine = $cartProductCapsule->getOrderLine();

                $transaction->ar_invoice_id = $this->arInvoice->ar_invoice_id;
                $transaction->order_id      = $this->order->order_id;
                $transaction->order_line_id = $orderLine->order_line_id;

                $transactionResult          = $transactions->createNew($transaction);
                $transaction                = $transactionResult->getData()->first();

                $cartProductCapsule->setTransaction($transaction);

                return $cartProductCapsule;
            });

            return $currPackageLine;
        });

        return true;
    }

    private function processProcessingFee() : void
    {
        $this->processingFee = sprintf ("%.2f", (($this->totalCartValue) *  0.0298662) + .3);
    }

    private function processPromoCodeIfApplicable() : void
    {
        $this->totalCartValue = $this->grossCartValue;

        if ($this->promoCode === null)
        {
            $this->totalProductsValue = $this->grossProductsValue;
            return;
        }

        switch($this->promoCode->discount_type)
        {
            case "%":
                $this->totalCartValue *= ($this->promoCode->discount_value / 100);
                break;
            default:
                $this->totalCartValue -= $this->promoCode->discount_value;
                break;
        }

        $this->promoToTotalPercentage = $this->totalCartValue / $this->grossCartValue;
        $this->totalProductsValue = $this->promoToTotalPercentage * $this->grossProductsValue;
        $this->processPromoCodeOnEachPackageLineTransaction();

        $this->totalCartValue = round($this->totalCartValue, 2);
        $this->totalProductsValue = round($this->totalProductsValue, 2);
    }

    private function loopThroughPackageLines($callback) : void
    {
        $this->packages->Foreach(function(PackageModel $currPackage) use ($callback)
        {
            return $this->packageSearch->loopThroughLinesFromPackageRecord($currPackage, $callback);
        });
    }

    private function processPackageLinesAndCreateTransactions() : void
    {
        $totalCartValue = 0;
        $totalProductsValue = 0;

        $this->loopThroughPackageLines(function(PackageLineModel $currPackageLine, PackageModel $currPackage) use (&$totalCartValue, &$totalProductsValue)
        {
            /** @var $currPackageLine->entities ExcellCollection */
            $currPackageLine->AddUnvalidatedValue("entities", new ExcellCollection());
            $quantity = ($currPackageLine->quantity ?? 1) * ($currPackage->cart_quantity ?? 1);

            for($currPackageLineIndex = 0; $currPackageLineIndex < $quantity; $currPackageLineIndex++)
            {
                $transaction = new TransactionModel();

                $transaction->company_id          = $this->companyId;
                $transaction->division_id         = 0;
                $transaction->package_id          = $currPackage->package_id;
                $transaction->package_line_id     = $currPackageLine->package_line_id;
                $transaction->product_entity      = $currPackageLine->product_entity;
                $transaction->product_entity_id   = $currPackageLine->product_entity_id;
                $transaction->user_id             = $this->userId;
                $transaction->tax                 = 0;
                $transaction->transaction_type_id = 1;


                $transaction->gross_value         = $this->processGrossValueFromPackageAndProduct($currPackageLine, $totalProductsValue);

                $totalCartValue += $transaction->gross_value;

                $productCapsule = new CartProductCapsule();
                $productCapsule->setTransaction($transaction)->setProduct($currPackageLine->product)->setPackageLine(new PackageLineModel($currPackageLine));

                $currPackageLine->entities->Add($productCapsule);
            }

            return $currPackageLine;
        });

        $this->grossCartValue = $totalCartValue;
        $this->grossProductsValue = $totalProductsValue;

        if ($this->stripeAccountType === "connected")
        {
            $this->netToGrossPercentage = $this->grossProductsValue / $this->grossCartValue;
        }
    }

    private function processPromoCodeOnEachPackageLineTransaction() : void
    {
        $this->packages->Foreach(function(PackageModel $currPackage) use (&$totalCartValue)
        {
            if (empty($currPackage->lines) || !is_a($currPackage->lines, ExcellCollection::class)) { return; }

            $currPackage->lines->Foreach(function(PackageLineModel $currPackageLine)
            {
                if (empty($currPackageLine->entities)) { return; }

                $currPackageLine->entities->Foreach(function(CartProductCapsule $cartProductCapsule)
                {
                    if (empty($cartProductCapsule->transaction) || empty($cartProductCapsule->transaction->gross_value)) { return; }

                    $cartProductCapsule->transaction->gross_value = round($cartProductCapsule->transaction->gross_value * $this->promoToTotalPercentage, 2);

                    return $cartProductCapsule;
                });

                return $currPackageLine;
            });

            return $currPackage;
        });
    }

    private function processGrossValueFromPackageAndProduct(PackageLineModel $packageLine, &$totalProductsValue) : float
    {
        $packageValue = ($packageLine->promo_price > 0 ? $packageLine->promo_price : $packageLine->regular_price);
        $totalProductsValue += ($packageLine->product_promo_price_override ?? $packageLine->product_price_override ?? $packageLine->product->value);

        return (float) $packageValue;
    }

    private function getBillingAccountId($userId) : int
    {
        $globalBillingAccountId = $this->app->objCustomPlatform->getCompanySettings()->FindEntityByValue("label", "global_billing_account_id");
        return (int) !empty($globalBillingAccountId) ? $globalBillingAccountId->value : $userId;
    }

    private function getCustomerStripeAccountId($typeId = 1) : ?string
    {
        $intBillingUserAccountId = $this->getBillingAccountId($this->userId);
        $paymentPropertyResult = (new UserPaymentProperty())->getWhere(["user_id" => $intBillingUserAccountId, "company_id" => $this->companyId, "state" => $this->env, "type_id" => $typeId]);
        if ($paymentPropertyResult->result->Count === 0) { return null; }
        return $paymentPropertyResult->getData()->first()->value;
    }

    private function processTransactionReturn() : CartProcessTransaction
    {
        if ($this->errors->Count() > 0)
        {
            $this->transactionResult->setErrors($this->errors);
        }
        else
        {
            $this->transactionResult->setPackages($this->packages)->setSuccessTrue();
            $this->transactionResult->order = $this->order;
            $this->transactionResult->arInvoice = $this->arInvoice;
            $this->transactionResult->userId = $this->userId;
            $this->transactionResult->companyId = $this->companyId;
            $this->transactionResult->defaultUserId = $this->defaultUserId;

            $this->transactionResult->totalCartValue = $this->totalCartValue;
            $this->transactionResult->totalProductsValue = $this->totalProductsValue;
        }

        return $this->transactionResult;
    }

    protected function totalProcessingValue() : float
    {
        return $this->totalCartValue + $this->processingFee;
    }
}