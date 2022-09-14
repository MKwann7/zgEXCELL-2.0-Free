<?php

namespace Http\Cart\Controllers;

use App\Utilities\Database;
use App\Utilities\Excell\ExcellCollection;
use App\Utilities\Excell\ExcellHttpModel;
use Entities\Cart\Classes\CartTicketProcess;
use Entities\Cart\Components\Vue\MarketplaceApp;
use Entities\Cards\Classes\Cards;
use Entities\Cards\Models\CardModel;
use Entities\Companies\Classes\Departments\Departments;
use Entities\Companies\Classes\Departments\DepartmentTicketQueues;
use Entities\Packages\Classes\Packages;
use Entities\Users\Classes\UserClass;
use Http\Cart\Controllers\Base\CartController;
use Entities\Cart\Classes\CartEmails;
use Entities\Cart\Classes\CartProcess;
use Entities\Cart\Classes\CartProductCapsule;
use Entities\Cart\Classes\Carts;
use Entities\Cart\Classes\PromoCodes;
use Entities\Cart\Components\Vue\CartWidget\CartWidget;
use Entities\Orders\Classes\OrderLines;
use Entities\Packages\Models\PackageLineModel;
use Entities\Payments\Classes\UserPaymentProperty;
use Entities\Payments\Models\PaymentAccountModel;
use Entities\Payments\Models\UserPaymentPropertyModel;
use Entities\Products\Classes\ProductProcessor;
use Entities\Products\Classes\Products;
use Entities\Products\Models\ProductModel;
use Vendors\Stripe\Main\Stripe;
use Vendors\Stripe\Main\StripeAddress;
use Entities\Companies\Models\CompanyModel;
use Entities\Packages\Classes\PackageLines;
use Entities\Packages\Models\PackageModel;
use Entities\Payments\Classes\PaymentAccounts;
use Entities\Users\Classes\Users;
use Entities\Users\Models\UserModel;

class IndexController extends CartController
{
    public function index(ExcellHttpModel $objData) : bool
    {
        if($this->app->isAdminUrlRequest())
        {
            if($this->app->isUserLoggedIn())
            {
                if($this->app->strActivePortalBinding === "account")
                {
                    switch($this->AppEntity->strAliasName)
                    {
                        case "marketplace":
                            $this->RenderMarketPlaceApp($objData);
                            break;
                    }
                }
                else
                {
                    $this->app->redirectToLogin();
                }
            }
            else
            {
                $this->app->redirectToLogin();
            }
        }
        else
        {
            $this->app->redirectToLogin();
        }

        return false;
    }

    public function RenderMarketPlaceApp(ExcellHttpModel $objData, $strApproach = "list") : void
    {
        $vueApp = (new MarketplaceApp("vueApp"))
            ->setUriBase($objData->PathControllerBase);
        //            ->registerComponentAbstracts([
        //                ManageCardWidget::getStaticId() => ManageCardWidget::getStaticUriAbstract(),
        //            ]);

        (new Carts())->renderApp(
            "marketplace.index",
            $this->app->strAssignedPortalTheme,
            $vueApp
        );
    }

    public function getCheckoutForIframe(ExcellHttpModel $objData): bool
    {
        $objCart = new Carts();
        $content = $objCart->getView("public.public_cart", $this->app->strAssignedPortalTheme, []);

        die($content);
    }

    public function getCheckout(ExcellHttpModel $objData): bool
    {
        $objCart = new Carts();
        $content = $objCart->getView("public.public_cart", $this->app->strAssignedPortalTheme, []);

        die($content);
    }

    public function getPublicCart(ExcellHttpModel $objData): bool
    {
        $objCartWidget = new CartWidget();
        $widget = $objCartWidget->renderComponentForAjaxDelivery();

        return $this->renderReturnJson(true, base64_encode($widget), "Here's what we got.", 200, "widget");
    }

    private function getBillingAccountId($userId): int
    {
        $globalBillingAccountId = $this->app->objCustomPlatform->getCompanySettings()->FindEntityByValue("label", "global_billing_account_id");
        return (int) !empty($globalBillingAccountId) ? $globalBillingAccountId->value : $userId;
    }

    private function getCustomerStripeAccountId ($userId, $companyId, $environment, $typeId = 1): ?int
    {
        $intBillingUserAccountId = $this->getBillingAccountId($userId);
        $paymentPropertyResult   = (new UserPaymentProperty())->getWhere(["user_id"    => $intBillingUserAccountId,
                                                                          "company_id" => $companyId,
                                                                          "state"      => $environment,
                                                                          "type_id"    => $typeId
        ]
        );
        if ($paymentPropertyResult->result->Count === 0)
        {
            return null;
        }
        return $paymentPropertyResult->getData()->first()->value;
    }

    public function submitOrderCheckout(ExcellHttpModel $objData): bool
    {
        $objPost = $this->app->objHttpRequest->Data->PostData;

        if (!$this->validate($objPost, [
            "package_ids" => "required",
            "user_id"     => "required|integer",
            "promo_code"  => "required|integer",
            "cart_type"   => "required",
        ]
        ))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $userId           = (int) $objPost->user_id;
        $paymentAccountId = (int) $objPost->payment_id;
        $parentEntity     = null;

        if ($objPost->cart_type !== "card" && $objPost->parent_entity_type === "card")
        {
            $parentEntity = (new Cards())->getById($objPost->parent_entity_id)->getData()->first();
        }

        $cartProcess = new CartProcess($objPost->package_ids, $userId, $paymentAccountId, $this->app);

        if ($objPost->promo_code !== 0)
        {
            $cartProcess->processPromoCode($objPost->promo_code);
        }

        $cartProcessTransaction = $cartProcess->processCheckout();

        if ($cartProcessTransaction->getTransaction()->result->Success !== true)
        {
            return $this->renderReturnJson(false, ["errors" => $cartProcessTransaction->getErrors()->ToPublicArray()], $cartProcessTransaction->getTransaction()->result->Message);
        }

        $productProcessor = new ProductProcessor($cartProcessTransaction);

        if (!$productProcessor->processLoadedProducts($parentEntity))
        {
            return $this->renderReturnJson(false, ["errors" => $productProcessor->generateProductCreationErrors()], "There was an error processing your order.");
        }

        $ticketProcess = new CartTicketProcess($productProcessor, $this->app);
        $ticketProcess->registerTickets();

        $cartEmails = new CartEmails($productProcessor, $this->app);
        $cartEmails->sendEmails();

        $cardItems = new ExcellCollection();

        /** @var CartProductCapsule $currCartItem */
        foreach ($productProcessor->cartItems as $currCartItem)
        {
            $cardResult = (new Cards())->getByUuid($currCartItem->getProductInstantiation()->sys_row_id);

            /** @var CardModel $card */
            $card = $cardResult->getData()->first();

            if ( $card !== null) {
                $card->LoadCardPages(false);
                $card->LoadCardConnections(false);
                $card->LoadCardContacts();

                $cardItems->Add($card);
            }
        }

        return $this->renderReturnJson(true, ["list" => $cardItems->ToPublicArray()], "We found this.");
    }

    public function registerPaymentAccountWithCard(ExcellHttpModel $objData): bool
    {
        if (!$this->validateRequestType('POST'))
        {
            return false;
        }

        $objParams = $this->app->objHttpRequest->Data->Params;
        $objPost = $this->app->objHttpRequest->Data->PostData;

        if (!$this->validate($objParams, [
            "id" => "required|integer",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        if (!$this->validate($objPost, [
            "payment_account_id" => "required|integer",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $orderLineResult = (new Cards())->getOrderLineByCardId($objParams["id"]);

        if ($orderLineResult->result->Count !== 1)
        {
            return $this->renderReturnJson(false, $orderLineResult->result->Message, "No card found by requested Id.");
        }

        $card = $orderLineResult->getData()->first();
        $card->payment_account_id = $objPost->payment_account_id;

        $cardUpdateResult = (new OrderLines())->update($card);

        if ($cardUpdateResult->result->Success === false)
        {
            $this->renderReturnJson(false, ["errors" => [$cardUpdateResult->result->Message]], "Card update error.");
        }

        return $this->renderReturnJson(true, [], "We found this.");
    }

    public function registerCreditCardWithUser(ExcellHttpModel $objData) : bool
    {
        if (!$this->validateRequestType('POST'))
        {
            return false;
        }

        $objParams = $this->app->objHttpRequest->Data->Params;
        $objPost = $this->app->objHttpRequest->Data->PostData;

        if (!$this->validate($objParams, [
            "id" => "required|integer",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        if (!$this->validate($objPost, [
            "number" => "required|integer",
            "expMonth" => "required|integer",
            "expYear" => "required|integer",
            "cvc" => "required|integer",
            "street" => "",
            "line1" => "required",
            "city" => "required",
            "zip" => "required",
            "country" => "required",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $stripe = new Stripe();

        $objUserPaymentProperty = new UserPaymentProperty();

        $environment = env("APP_ENV") === "production" ? "prod" : "test";

        $customPlatformId = $this->app->objCustomPlatform->getCompanyId();
        $globalBillingAccountId = $this->app->objCustomPlatform->getCompanySettings()->FindEntityByValue("label", "global_billing_account_id");
        $intBillingUserAccountId = (!empty($globalBillingAccountId) ? $globalBillingAccountId->value : $objParams["id"]);

        $result = $objUserPaymentProperty->getWhere(["user_id" => $intBillingUserAccountId, "company_id" => $customPlatformId, "state" => $environment, "type_id" => 1]);

        if ($result->result->Count === 0 || $result->result->Success === false)
        {
            $stripeCustomer = $stripe->createCustomerFromUser((int) $intBillingUserAccountId, [
                "line1" => $objPost->line1,
                "line2" => $objPost->line3,
                "city" => $objPost->city,
                "zip" => $objPost->zip,
                "country" => $objPost->country,
            ]);

            if ($stripe->stripedErrored())
            {
                return $this->renderReturnJson(false, ["error" => "Could not create a user, missing email or phone"], $stripe->getFirstError());
            }

            $userPaymentProperty = new UserPaymentPropertyModel();
            $userPaymentProperty->company_id = $customPlatformId;
            $userPaymentProperty->user_id = $intBillingUserAccountId;
            $userPaymentProperty->type_id = 1;
            $userPaymentProperty->state = $environment;
            $userPaymentProperty->value = $stripeCustomer->id;

            $result = $objUserPaymentProperty->createNew($userPaymentProperty);

            if ($result->result->Count === 0)
            {
                return $this->renderReturnJson(false, ["error" => $result->result->Message], "Error in registering user payment property.");
            }
        }

        $stripeCustomerId = $result->getData()->first()->value;

        $token = $stripe->createCardToken(
            $objPost->name,
            $objPost->number,
            $objPost->expMonth,
            $objPost->expYear,
            $objPost->cvc,
            "usd",
            new StripeAddress($objPost->line1, $objPost->line2, $objPost->city, $objPost->state, $objPost->zip, $objPost->country)
        );

        $paymentMethod = $stripe->createCardPaymentMethod($token->id);
        $paymentMethodId = $paymentMethod->id;
        $setup_intent = null;
        $intentResult = null;

        try
        {
            $setup_intent = $stripe->createCardSetupIntent($stripeCustomerId, $paymentMethodId);
            $intentResult = $stripe->confirmSetupIntent($setup_intent->id, $paymentMethodId);
        }
        catch(\Exception $ex)
        {
            return $this->renderReturnJson(false, ["error" => $ex->getMessage()], "Fatal error creating payment object.");
        }

        if ($intentResult->status !== "succeeded")
        {
            return $this->renderReturnJson(false, ["error" => $intentResult->next_action], $intentResult->next_action);
        }

        $objPaymentAccounts = new PaymentAccounts();
        $paymentAccount = new PaymentAccountModel();

        $paymentAccount->company_id = $customPlatformId;
        $paymentAccount->division_id = 0;
        $paymentAccount->user_id = $intBillingUserAccountId;
        $paymentAccount->payment_type = 1;
        $paymentAccount->method = "credit-card";
        $paymentAccount->token = $paymentMethodId;
        $paymentAccount->type = $objPost->type;
        $paymentAccount->display_1 = "**" . substr($objPost->number, -4);
        $paymentAccount->display_2 = $objPost->expMonth . "/" . substr($objPost->expYear, -2);
        $paymentAccount->expiration_date = $objPost->expYear . "-" . $objPost->expMonth . "-01 00:00:00";

        $paymentAccountResult = $objPaymentAccounts->createNew($paymentAccount);

        if ($paymentAccountResult->result->Success === false)
        {
            return $this->renderReturnJson(false, ["error" => $paymentAccountResult->result->Message], "Error creating payment account.");
        }

        return $this->renderReturnJson(($paymentAccountResult->result->Count === 1 ? true : false), $paymentAccountResult->getData()->first()->ToArray(), "Payment account registered.");
    }

    public function getUserPaymentAccounts() : bool
    {
        $objParams = $this->app->objHttpRequest->Data->Params;

        if (!$this->validate($objParams, [
            "id" => "required|integer",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $customPlatformId = $this->app->objCustomPlatform->getCompany()->company_id;

        $globalBillingAccountId = $this->app->objCustomPlatform->getCompanySettings()->FindEntityByValue("label", "global_billing_account_id");

        $objPaymentAccounts = new PaymentAccounts();
        $accountResult = $objPaymentAccounts->getWhere(["status"=> "active","company_id" => $customPlatformId, "user_id" => (!empty($globalBillingAccountId) ? $globalBillingAccountId->value : $objParams["id"])]);

        $arAccountList = array(
            "paymentAccounts" => $accountResult->getData()->ToPublicArray(["payment_account_id", "method", "type", "display_1", "display_2", "sys_row_id"]),
        );

        return $this->renderReturnJson(true, $arAccountList, "We found this.");
    }

    public function getCheckoutData(ExcellHttpModel $objData) : bool
    {
        $objParams = $this->app->objHttpRequest->Data->Params;

        if (!$this->validate($objParams, [
            "id" => "required|integer",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $customPlatformId = $this->app->objCustomPlatform->getCompany()->company_id;

        $objPaymentAccounts = new PaymentAccounts();

        $globalBillingAccountId = $this->app->objCustomPlatform->getCompanySettings()->FindEntityByValue("label", "global_billing_account_id");

        $accountResult = $objPaymentAccounts->getWhere(["status"=> "active","company_id" => $customPlatformId, "user_id" => (!empty($globalBillingAccountId) ? $globalBillingAccountId->value : $objParams["id"])]);

        $objPromoCodes = new PromoCodes();
        $whereClause = ["company_id" => $customPlatformId, "expired" => EXCELL_FALSE];

//        if (env("APP_ENV") === "production")
//        {
//            $whereClause["test_only"] = ExcellFalse;
//        }

        $promoCodeResult = $objPromoCodes->getWhere($whereClause);

        $promoCodeResult->getData()->Each(function($currCode) use ($objPromoCodes)
        {
            if (!empty($currCode->expiration_date) && strtotime($currCode->expiration_date) < strtotime(date("Y-m-d H:i:s")))
            {
                $currCode->expired = EXCELL_TRUE;
                $objPromoCodes->update($currCode);
            }
        });

        $arAccountList = array(
            "paymentAccounts" => $accountResult->getData()->ToPublicArray(["payment_account_id", "method", "type", "display_1", "display_2", "sys_row_id"]),
            "promoCodes" => $promoCodeResult->getData()->ToPublicArray(["promo_code_id", "promo_code", "title", "description", "discount_value", "discount_type"]),
            "query" => $promoCodeResult->result->Query,
        );

        return $this->renderReturnJson(true, $arAccountList, "We found this.");
    }

    public function getUserInformation(ExcellHttpModel $objData) : bool
    {
        $objParams = $this->app->objHttpRequest->Data->Params;

        if (!$this->validate($objParams, [
            "id" => "required|integer",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objUsers = new Users();
        $userResult = $objUsers->getFks()->getById($objParams["id"]);

        $objUser = $userResult->getData()->first();

        $arUserList = array(
            "user" => $objUser->ToPublicArray(["name_prefix", "first_name", "last_name", "name_sufx", "user_phone", "user_email", "user_id", "sys_row_id"]),
        );

        return $this->renderReturnJson(($userResult->result->Count === 1 ? true : false), $arUserList, "We found this.");
    }

    public function getAllUsers(ExcellHttpModel $objData) : bool
    {
        // TODO - Make sure Custom Platform Data is handed out
        // TODO - Make Secure

        $customPlatformId = $this->app->objCustomPlatform->getCompany()->company_id;

        $objUsers = new Users();
        $userResult = $objUsers->getWhere(["company_id" => $customPlatformId, "status" => "Active"]);
        $activeUser = $this->app->getActiveLoggedInUser();

        $foundActiveUser = false;
        $userResult->getData()->Foreach(function($currUser) use ($activeUser, &$foundActiveUser) {
            if ($currUser->user_id === $activeUser->user_id) {
                $foundActiveUser = true;
            }
        });

        if ($foundActiveUser === false) {
            $userResult->getData()->Add($activeUser);
        }

        $arUserList = array(
            "list" => $userResult->getData()->FieldsToArray(["user_id", "first_name", "last_name"]),
        );

        return $this->renderReturnJson(($userResult->result->Count > 0 ? true : false), $arUserList, "We found this.");
    }

    public function getAllCardUsers(ExcellHttpModel $objData) : bool
    {
        $customPlatformId = $this->app->objCustomPlatform->getCompany()->company_id;

        $objUsers = new Users();
        $userResult = $objUsers->getFks(["user_email","user_phone"])->getWhere(["company_id" => $customPlatformId, "status" => "Active"]);

        $arUserList = array(
            "list" => $userResult->getData()->FieldsToArray(["user_id", "first_name", "last_name","user_email","user_phone"]),
        );

        return $this->renderReturnJson(($userResult->result->Count > 0 ? true : false), $arUserList, "We found this.");
    }

    public function getAllCardUsersCount(ExcellHttpModel $objData) : bool
    {
        $customPlatformId = $this->app->objCustomPlatform->getCompany()->company_id;

        $objUsers = new Users();
        $userResult = $objUsers->getCountWhere(["company_id" => $customPlatformId, "status" => "Active"]);

        $arUserList = array(
            "count" => $userResult->result->Count,
        );

        return $this->renderReturnJson(($userResult->result->Count > 0 ? true : false), $arUserList, "We found this.");
    }

    public function getAllAffiliates(ExcellHttpModel $objData) : bool
    {
        $customPlatformId = $this->app->objCustomPlatform->getCompany()->company_id;

        $objWhereClause = "
            SELECT u.*
            FROM `user_class` uc
            LEFT JOIN user u ON uc.user_id = u.user_id WHERE u.company_id = {$customPlatformId} AND uc.user_class_type_id = 15 AND u.status = 'Active'";

        $userResult = Database::getSimple($objWhereClause,"user_id");
        $userResult->getData()->HydrateModelData(UserModel::class, true);

        $arUserList = array(
            "list" => $userResult->getData()->FieldsToArray(["user_id", "first_name", "last_name"]),
        );

        return $this->renderReturnJson(($userResult->result->Count > 0 ? true : false), $arUserList, "We found this.");
    }

    public function getPackageByIdForCart(ExcellHttpModel $objData) : bool
    {
        $objParams= $this->app->objHttpRequest->Data->Params;

        if (!$this->validate($objParams, [
            "id" => "required",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $objPackages = (new Packages())->getById($objParams["id"]);

        if ($objPackages->result->Count !== 1)
        {
            return $this->renderReturnJson(true, null, "Package not found by id.");
        }

        $objPackageList = ( new PackageLines())->getWhereIn("package_id", $objPackages->getData()->FieldsToArray(["package_id"]));
        $objPackages->getData()->HydrateChildModelData("line", ["package_id" => "package_id"], $objPackageList->data, false);

        $productIds = [];
        $objPackageList->getData()->Each(static function(PackageLineModel $currPackageLine) use (&$productIds) {

            if ($currPackageLine->product_entity === "product")
            {
                $productIds[] = $currPackageLine->product_entity_id;
            }
        });

        $objProducts = new Products();
        $productResult = $objProducts->getWhereIn("product_id", $productIds);

        $objPackages->getData()->Foreach(static function(PackageModel $currPackage) use ($productResult) {

            if (empty($currPackage->line)) { return; }

            $currPackage->line->Foreach(static function(PackageLineModel $currPackageLine) use ($productResult)
            {
                if ($currPackageLine->product_entity = "product")
                {
                    $productResult->getData()->Foreach(static function (ProductModel $currProductModel) use (&$currPackageLine)
                    {
                        if ($currPackageLine->product_entity_id === $currProductModel->product_id)
                        {
                            $currPackageLine->AddUnvalidatedValue("product", $currProductModel);
                            $currPackageLine->AddUnvalidatedValue("product_type_id", $currProductModel->product_type_id);
                        }
                    });

                    return $currPackageLine;
                }
            });

            return $currPackage;
        });

        $arPackageList = array(
            "package" => $objPackages->getData()->first()->ToArray(),
        );

        return $this->renderReturnJson(true, $arPackageList, "We found this.");
    }

    public function getPackagesByClassName(ExcellHttpModel $objData) : bool
    {
        $objParams= $this->app->objHttpRequest->Data->Params;

        if (!$this->validate($objParams, [
            "name" => "required",
        ]))
        {
            return $this->renderReturnJson(false, $this->validationErrors, "Validation errors.");
        }

        $customPlatformId = $this->app->objCustomPlatform->getCompany()->company_id;
        $className = $objParams["name"];
        $isAdminRole = $objParams["e"];

        $onlyEndUser = "";

        if (!userCan("manage-platforms") || $isAdminRole !== true)
        {
            $onlyEndUser = " AND p.enduser_id = 1";
        }

        $objWhereClause = "
            SELECT p.*, peu.enduser_label, peu.description as enduser_desc
            FROM excell_main.package_class pc
            LEFT JOIN excell_main.package_class_rel pcr ON pc.package_class_id = pcr.package_class_id
            LEFT JOIN excell_main.package p ON pcr.package_id = p.package_id
            LEFT JOIN excell_main.product_enduser peu ON peu.product_enduser_id = p.enduser_id ";

        if (in_array($this->app->getActiveLoggedInUser()->user_id, [1002, 1003, 70726, 73837, 90999, 91003, 91015, 91014]))
        {
            $objWhereClause .= "WHERE p.company_id = {$customPlatformId} AND pc.name = '{$className}' AND p.package_id != 27 $onlyEndUser";
        }
        else
        {
            $objWhereClause .= "WHERE p.company_id = {$customPlatformId} AND pc.name = '{$className}'$onlyEndUser";
        }

        $objWhereClause .= " ORDER BY p.order ASC";

        $objPackages = Database::getSimple($objWhereClause,"package_id");
        $objPackages->getData()->HydrateModelData(PackageModel::class, true);

        $objPackageList = ( new PackageLines())->getWhereIn("package_id", $objPackages->getData()->FieldsToArray(["package_id"]));
        $objPackages->getData()->HydrateChildModelData("line", ["package_id" => "package_id"], $objPackageList->data, false);

        $productIds = [];
        $objPackageList->getData()->Each(static function(PackageLineModel $currPackageLine) use (&$productIds) {

            if ($currPackageLine->product_entity === "product")
            {
                $productIds[] = $currPackageLine->product_entity_id;
            }
        });

        $objProducts = new Products();
        $productResult = $objProducts->getWhereIn("product_id", $productIds);

        $objPackages->getData()->Foreach(static function(PackageModel $currPackage) use ($productResult) {

            if (empty($currPackage->line)) { return; }

            $currPackage->line->Foreach(static function(PackageLineModel $currPackageLine) use ($productResult)
            {
                if ($currPackageLine->product_entity = "product")
                {
                    $productResult->getData()->Foreach(static function (ProductModel $currProductModel) use (&$currPackageLine)
                    {
                        if ($currPackageLine->product_entity_id === $currProductModel->product_id)
                        {
                            $currPackageLine->AddUnvalidatedValue("product", $currProductModel);
                            $currPackageLine->AddUnvalidatedValue("product_type_id", $currProductModel->product_type_id);
                        }
                    });

                    return $currPackageLine;
                }
            });

            return $currPackage;
        });

        $arPackageList = array(
            "list" => $objPackages->getData()->ToPublicArray(),
        );

        return $this->renderReturnJson(true, $arPackageList, "We found this.");
    }

    public function getPlatformBatches(ExcellHttpModel $objData) : bool
    {
        if (!userCan("manage-platforms"))
        {
            return $this->renderReturnJson(false, [], "Unauthorized", 401);
        }

        $pageIndex = $objData->Data->Params["offset"] ?? 1;
        $batchCount = $objData->Data->Params["batch"] ?? 500;
        $pageIndex = ($pageIndex - 1) * $batchCount;
        $arFields = explode(",", $objData->Data->Params["fields"]);
        $strEnd = "false";

        $objWhereClause = "
            SELECT packages.*,
            platform_name AS platform,
            domain_portal AS portal_domain,
            domain_public AS public_domain,
            (SELECT CONCAT(user.first_name, ' ', user.last_name) FROM `excell_main`.`user` WHERE user.user_id = company.owner_id LIMIT 1) AS owner,
            (SELECT COUNT(*) FROM `excell_main`.`card` cd WHERE cd.company_id = company.company_id) AS cards
            FROM `company` ";

        $objWhereClause .= " ORDER BY company.company_id ASC LIMIT {$pageIndex}, {$batchCount}";

        $objCards = Database::getSimple($objWhereClause,"company_id");

        if ($objCards->getData()->Count() < $batchCount)
        {
            $strEnd = "true";
        }

        $objCards->getData()->HydrateModelData(CompanyModel::class, true);

        $arUserDashboardInfo = array(
            "list" => $objCards->getData()->FieldsToArray($arFields),
        );

        return $this->renderReturnJson(true, $arUserDashboardInfo, "We found " . $objCards->getData()->Count() . " companies in this batch.", 200, "data", $strEnd);
    }

    public function sendEmailsForCart(ExcellHttpModel $objData) : bool
    {
        //$cartEmails = new CartEmails($this->app, (new Users())->getFks(["user_phone", "user_email"])->getById(1000)->getData()->first());
        //$cartEmails->processEmailForConnectedCart($this->app);

        return true;
    }
}