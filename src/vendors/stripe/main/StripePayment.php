<?php

namespace Vendors\Stripe\Main;

class StripePayment
{
    protected $amount;
    protected $currency;
    protected $applicationFeeAmount;
    protected $processImmediately;

    public function __construct($amount, $applicationFeeAmount, $currency, $processImmediately = true)
    {
        $this->amount = $amount * 100;
        $this->applicationFeeAmount = $applicationFeeAmount * 100;
        $this->currency = $currency;
        $this->processImmediately = $processImmediately;
    }

    public function getAmount() : float
    {
        return $this->amount;
    }

    public function getCurrency() : string
    {
        return $this->currency;
    }

    public function getApplicationFeeAmount() : float
    {
        return $this->applicationFeeAmount;
    }

    public function getProcessImmediately() : bool
    {
        return $this->processImmediately;
    }
}