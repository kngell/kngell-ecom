<?php

declare(strict_types=1);

class ShowAddress extends AbstractShowAddress implements DisplayPagesInterface
{
    public function __construct(?CustomerEntity $customerEntity = null, ?AddressBookPage $addressBook = null, ?Modals $modals = null, ?UserAccountPaths $paths = null)
    {
        parent::__construct($customerEntity, $addressBook, $modals, $paths);
    }

    public function displayAll(): mixed
    {
        return [
            $this->addressBook->setCustomer($this->customerEntity)->displayAll()['addressBook'],
            $this->modals->addAddressModal(),
        ];
    }
}
