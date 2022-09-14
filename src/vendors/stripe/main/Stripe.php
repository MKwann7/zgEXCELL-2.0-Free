<?php

namespace Vendors\Stripe\Main;

use Entities\Payments\Classes\UserPaymentProperty;
use Entities\Users\Classes\UserAddress;
use Entities\Users\Classes\Users;
use Stripe\Customer;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

class Stripe
{
    protected StripeClient $stripe;
    protected string $key;
    protected ?string $customPlatformId = null;
    private bool $stripeError = false;

    public function __construct ()
    {

        include_once APP_VENDORS . "stripe/main/v7_47_0/init.php";

        if (env("STRIPE_ENV") === "production")
        {
            $this->key = env("STRIPE_KEY_PROD");
        }
        else
        {
            $this->key = env("STRIPE_KEY_TEST");
        }

        $this->customPlatformId = $this->getConnectedAccountStripeId();

        $this->stripe = new StripeClient(
            $this->key
        );
    }

    public function getCustomPlatformId() : ?string
    {
        return $this->customPlatformId;
    }

    private function getConnectedAccountStripeId() : ?string
    {
        global $app;
        $paymentPropertyResult = (new UserPaymentProperty())->getWhere(["user_id" => $app->objCustomPlatform->getCompany()->owner_id, "company_id" => $app->objCustomPlatform->getCompanyId(), "state" => "all", "type_id" => 2]);
        if ($paymentPropertyResult->result->Count === 0) { return null; }
        return $paymentPropertyResult->getData()->first()->value;
    }

    /**
     * @param StripePayment $payment
     * @param $customerId
     * @param $paymentMethod
     * @param bool $offSession
     * @return \Stripe\PaymentIntent
     * @throws ApiErrorException
     */

    public function createPaymentIntent(StripePayment $payment, $customerId, $paymentMethod, $offSession = true) : \Stripe\PaymentIntent
    {
        global $app;
        $stripeAccountType = $app->objCustomPlatform->getCompanySettings()->FindEntityByValue("label", "stripe_account_type");

        if (empty($stripeAccountType) || $stripeAccountType->value === "customer")
        {
            return $this->stripe->paymentIntents->create([
                'amount' => $payment->getAmount(),
                'currency' => $payment->getCurrency(),
                'customer' => $customerId,
                'payment_method' => $paymentMethod,
                'off_session' => $offSession,
                'confirm' => $payment->getProcessImmediately(),
            ]);
        }

        return $this->stripe->paymentIntents->create([
            'amount' => $payment->getAmount(),
            'currency' => $payment->getCurrency(),
            'customer' => $customerId,
            'payment_method' => $paymentMethod,
            'off_session' => $offSession,
            'confirm' => $payment->getProcessImmediately(),
            'application_fee_amount' => $payment->getApplicationFeeAmount(),
        ], $this->renderCustomPlatformId());
    }

    /**
     * @param StripeCustomer $customer
     * @return Customer
     * @throws ApiErrorException
     */

    public function createCustomer(StripeCustomer $customer) : ?Customer
    {
        global $app;
        $stripeAccountType = $app->objCustomPlatform->getCompanySettings()->FindEntityByValue("label", "stripe_account_type");

        try
        {
            $result = null;

            if (empty($stripeAccountType) || $stripeAccountType->value === "customer")
            {
                $result = $this->stripe->customers->create([
                    'name' => $customer->getFullName(),
                    'email' => $customer->getEmail(),
                    'phone' => $customer->getPhone(),
                    'address' => $customer->getAddressAsArray(),
                    'description' => $customer->getCustomPlatformDescription(),
                ]);
            }

            $result = $this->stripe->customers->create([
                'name' => $customer->getFullName(),
                'email' => $customer->getEmail(),
                'phone' => $customer->getPhone(),
                'address' => $customer->getAddressAsArray(),
                'description' => $customer->getCustomPlatformDescription(),
            ], $this->renderCustomPlatformId());

            $this->stripeError = false;

            return $result;
        }
        catch(ApiErrorException $ex)
        {
            $this->stripeError = true;
            $this->processError($ex);
            return null;
        }
    }

    public function stripedErrored() : bool
    {
        return $this->stripeError;
    }

    public function processError(ApiErrorException $ex) : void
    {
        $this->errors[] = $ex->getMessage();
    }

    public function getFirstError() : string
    {
        $array = array_reverse($this->errors);
        return array_pop($array);
    }

    /**
     * @param string $name
     * @param int $number
     * @param int $expMonth
     * @param int $expYear
     * @param int $cvc
     * @param string $currency
     * @param StripeAddress $address
     * @return \Stripe\Token
     * @throws ApiErrorException
     */

    public function createCardToken(string $name, int $number, int $expMonth, int $expYear, int $cvc, string $currency, StripeAddress $address) : \Stripe\Token
    {
        global $app;
        $stripeAccountType = $app->objCustomPlatform->getCompanySettings()->FindEntityByValue("label", "stripe_account_type");

        if (empty($stripeAccountType) || $stripeAccountType->value === "customer")
        {
            return $this->stripe->tokens->create([
                'card' => [
                    'name' => preg_replace("/[^a-zA-Z0-9]+/", "", $name),
                    'number' => preg_replace("/[^0-9\+]/", '', $number),
                    'exp_month' => preg_replace("/[^0-9\+]/", '', $expMonth),
                    'exp_year' => preg_replace("/[^0-9\+]/", '', $expYear),
                    'cvc' => preg_replace("/[^0-9\+]/", '', $cvc),
                    'currency' => $currency,
                    'address_line1' => $address->getLine1(),
                    'address_line2' => $address->getLine2(),
                    'address_city' => $address->getCity(),
                    'address_state' => $address->getState(),
                    'address_zip' => $address->getZip(),
                    'address_country' => $address->getCountry(),
                ]
            ]);
        }

        return $this->stripe->tokens->create([
            'card' => [
                'name' => preg_replace("/[^a-zA-Z0-9]+/", "", $name),
                'number' => preg_replace("/[^0-9\+]/", '', $number),
                'exp_month' => preg_replace("/[^0-9\+]/", '', $expMonth),
                'exp_year' => preg_replace("/[^0-9\+]/", '', $expYear),
                'cvc' => preg_replace("/[^0-9\+]/", '',$cvc),
                'currency' => $currency,
                'address_line1' => $address->getLine1(),
                'address_line2' => $address->getLine2(),
                'address_city' => $address->getCity(),
                'address_state' => $address->getState(),
                'address_zip' => $address->getZip(),
                'address_country' => $address->getCountry(),
            ]
        ], $this->renderCustomPlatformId());
    }

    /**
     * @param string $cardToken
     * @return \Stripe\PaymentMethod
     * @throws ApiErrorException
     */

    public function createCardPaymentMethod(string $cardToken): \Stripe\PaymentMethod
    {
        global $app;
        $stripeAccountType = $app->objCustomPlatform->getCompanySettings()->FindEntityByValue("label", "stripe_account_type");

        if (empty($stripeAccountType) || $stripeAccountType->value === "customer")
        {
            return $this->stripe->paymentMethods->create([
                'type' => 'card',
                'card' => ["token" => $cardToken],

            ]);
        }

        return $this->stripe->paymentMethods->create([
            'type' => 'card',
            'card' => ["token" => $cardToken],

        ], $this->renderCustomPlatformId());
    }

    /**
     * @param string $customerId
     * @param string $paymentMethodId
     * @return \Stripe\SetupIntent
     * @throws ApiErrorException
     */

    public function createCardSetupIntent(string $customerId, string $paymentMethodId): \Stripe\SetupIntent
    {
        global $app;
        $stripeAccountType = $app->objCustomPlatform->getCompanySettings()->FindEntityByValue("label", "stripe_account_type");

        if (empty($stripeAccountType) || $stripeAccountType->value === "customer")
        {
            return $this->stripe->setupIntents->create([
                'usage' => 'off_session', // The default usage is off_session
                'customer' => $customerId,
                'payment_method_types' => ['card'],
                'payment_method' => $paymentMethodId,
            ]);
        }

        return $this->stripe->setupIntents->create([
            'usage' => 'off_session', // The default usage is off_session
            'customer' => $customerId,
            'payment_method_types' => ['card'],
            'payment_method' => $paymentMethodId,
        ], $this->renderCustomPlatformId());
    }

    /**
     * @param string $setupIntentId
     * @param string $paymentMethodId
     * @return \Stripe\SetupIntent
     * @throws ApiErrorException
     */

    public function confirmSetupIntent(string $setupIntentId, string $paymentMethodId): \Stripe\SetupIntent
    {
        global $app;
        $stripeAccountType = $app->objCustomPlatform->getCompanySettings()->FindEntityByValue("label", "stripe_account_type");

        if (empty($stripeAccountType) || $stripeAccountType->value === "customer")
        {
            return $this->stripe->setupIntents->confirm(
                $setupIntentId,
                ['payment_method' => $paymentMethodId]);
        }

        return $this->stripe->setupIntents->confirm(
            $setupIntentId,
            ['payment_method' => $paymentMethodId],
            $this->renderCustomPlatformId());
    }

    public function createCustomerFromUser(int $userId, array $address) : ?Customer
    {
        $objUser = (new Users())->getFks()->getById($userId)->getData()->first();

        if(empty($objUser->user_email) || !filter_var($objUser->user_email, FILTER_VALIDATE_EMAIL) || empty($objUser->user_phone))
        {
            return null;
        }

        $newCustomer = new StripeCustomer(
            $objUser->first_name,
            $objUser->last_name,
            $objUser->user_email,
            $objUser->user_phone
        );

        if (!empty($address["line1"]) && !empty($address["zip"]) && !empty($address["state"]) && !empty($address["country"]))
        {
            $newCustomer->addAddress(
                new StripeAddress(
                    $address["line1"],
                    $address["line2"],
                    $address["city"],
                    $address["state"],
                    $address["zip"],
                    $address["country"]
                )
            );
        }

        return $this->createCustomer($newCustomer);
    }

    protected function renderCustomPlatformId() : array
    {
        if ($this->customPlatformId !== null)
        {
            return ['stripe_account' => $this->customPlatformId];
        }

        return [];
    }
}