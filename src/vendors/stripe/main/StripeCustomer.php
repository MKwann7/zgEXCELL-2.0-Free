<?php

namespace Vendors\Stripe\Main;

class StripeCustomer
{
    protected $firstName;
    protected $lastName;
    protected $email;
    protected $phone;
    protected $address;

    public function __construct ($firstName, $lastName, $email = "", $phone = "", ?StripeAddress $address = null)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->phone = preg_replace("/[^0-9\+]/", '', $phone);
        $this->address = $address;
    }

    public function getFullName() : ?string
    {
        return $this->firstName . " " . $this->lastName;
    }

    public function getEmail() : ?string
    {
        return $this->email;
    }

    public function getPhone() : ?string
    {
        return $this->phone;
    }

    public function getAddressAsArray() : array
    {
        if ($this->address === null)
        {
            return [];
        }

        return $this->address->toArray();
    }

    public function addAddress(StripeAddress $address) : self
    {
        $this->address = $address;
        return $this;
    }

    public function getCustomPlatformDescription() : string
    {
        global $app;

        return $app->objCustomPlatform->getCompany()->company_name . " customer - " . $this->getFullName() . " <" .$this->getEmail() . ">";
    }
}