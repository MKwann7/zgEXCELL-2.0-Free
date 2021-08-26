<?php

namespace Vendors\Stripe\Main;

use Entities\Payments\Classes\UserPaymentProperty;
use Entities\Users\Classes\UserAddress;
use Entities\Users\Classes\Users;

class Stripe
{
    protected $stripe;
    protected $key;
    protected $customPlatformId = null;

    public function __construct ()
    {

        include_once AppVendors . "stripe/main/v7_47_0/init.php";

        if (env("STRIPE_ENV") === "production")
        {
            $this->key = env("STRIPE_KEY_PROD");
        }
        else
        {
            $this->key = env("STRIPE_KEY_TEST");
        }

        $this->customPlatformId = $this->getConnectedAccountStripeId();

        $this->stripe = new \Stripe\StripeClient(
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
        if ($paymentPropertyResult->Result->Count === 0) { return null; }
        return $paymentPropertyResult->Data->First()->value;
    }

    /**
     * @param StripePayment $payment
     * @param $customerId
     * @param $paymentMethod
     * @param bool $offSession
     * @return \Stripe\PaymentIntent
     * @throws \Stripe\Exception\ApiErrorException
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
     * @return \Stripe\Customer
     * @throws \Stripe\Exception\ApiErrorException
     */

    public function createCustomer(StripeCustomer $customer) : \Stripe\Customer
    {
        global $app;
        $stripeAccountType = $app->objCustomPlatform->getCompanySettings()->FindEntityByValue("label", "stripe_account_type");

        if (empty($stripeAccountType) || $stripeAccountType->value === "customer")
        {
            return $this->stripe->customers->create([
                'name' => $customer->getFullName(),
                'email' => $customer->getEmail(),
                'phone' => $customer->getPhone(),
                'address' => $customer->getAddressAsArray(),
                'description' => $customer->getCustomPlatformDescription(),
            ]);
        }


        return $this->stripe->customers->create([
            'name' => $customer->getFullName(),
            'email' => $customer->getEmail(),
            'phone' => $customer->getPhone(),
            'address' => $customer->getAddressAsArray(),
            'description' => $customer->getCustomPlatformDescription(),
        ], $this->renderCustomPlatformId());
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
     * @throws \Stripe\Exception\ApiErrorException
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
                    'cvc' => preg_replace($cvc),
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
                'cvc' => preg_replace($cvc),
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
     * @throws \Stripe\Exception\ApiErrorException
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
     * @throws \Stripe\Exception\ApiErrorException
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
     * @throws \Stripe\Exception\ApiErrorException
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

    public function createCustomerFromUser(int $userId) : \Stripe\Customer
    {
        $objUser = (new Users())->getFks()->getById($userId)->Data->First();
        $objUserAddress = (new UserAddress())->getWhere(["user_id" => $userId])->Data->First();

        $newCustomer = new StripeCustomer(
            $objUser->first_name,
            $objUser->last_name,
            $objUser->user_email,
            $objUser->user_phone
        );

        if (!empty($objUserAddress))
        {
            $newCustomer->addAddress(
                new StripeAddress(
                    $objUserAddress->address_1,
                    $objUserAddress->address_2,
                    $objUserAddress->city,
                    $objUserAddress->state,
                    $objUserAddress->zip,
                    $objUserAddress->country
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