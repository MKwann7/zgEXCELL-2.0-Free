<?php

namespace Vendors\Stripe\Main;

class StripeAddress
{
    protected $line1;
    protected $line2;
    protected $city;
    protected $state;
    protected $zip;
    protected $country;
    
    public function __construct ($line1, $line2 = "", $city = "", $state = "", $zip = "", $country = "")
    {
        $this->line1 = $line1;
        $this->line2 = $line2;
        $this->city = $city;
        $this->state = $state;
        $this->zip = $zip;
        $this->country = $this->covertToTwoLetters($country);
    }

    public function toArray() : array
    {
        return [
            "line1" => $this->line1,
            "line2" => $this->line2,
            "city" => $this->city,
            "state" => $this->state,
            "postal_code" => $this->zip,
            "country" => $this->country,
        ];
    }

    protected function covertToTwoLetters($country)
    {
        switch(strtolower($country))
        {
            case "usa":
            case "united states":
                return "US";
            default:
                return $country;
        }
    }

    public function getLine1() : string
    {
        return $this->line1;
    }

    public function getLine2() : string
    {
        return $this->line2;
    }

    public function getCity() : string
    {
        return $this->city;
    }

    public function getState() : string
    {
        return $this->state;
    }

    public function getZip() : string
    {
        return $this->zip;
    }

    public function getCountry() : string
    {
        return $this->country;
    }
}