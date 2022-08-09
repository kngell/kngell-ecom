<?php

declare(strict_types=1);

trait AddressBookGetterAndSettersTrait
{
    /**
     * Get the value of customer.
     */
    public function getCustomer() : Customer
    {
        return $this->customer;
    }

    /**
     * Set the value of customer.
     *
     * @return  self
     */
    public function setCustomer(Customer $customer) : self
    {
        $this->customer = $customer;
        return $this;
    }

    public function noForm(bool $nf) : self
    {
        $this->noManageForm = $nf;
        return $this;
    }
}