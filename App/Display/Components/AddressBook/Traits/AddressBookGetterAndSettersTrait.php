<?php

declare(strict_types=1);

trait AddressBookGetterAndSettersTrait
{
    /**
     * Get the value of customer.
     */
    public function getCustomer() : CustomerEntity
    {
        return $this->customerEntity;
    }

    /**
     * Set the value of customer.
     *
     * @return  self
     */
    public function setCustomer(CustomerEntity $customer) : self
    {
        $this->customerEntity = $customer;

        return $this;
    }

    public function noForm(bool $nf) : self
    {
        $this->noManageForm = $nf;

        return $this;
    }
}
