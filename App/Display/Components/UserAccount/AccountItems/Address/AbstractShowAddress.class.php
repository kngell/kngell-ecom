<?php

declare(strict_types=1);

abstract class AbstractShowAddress
{
    use DisplayTraits;
    use DisplayFormElementTrait;
    use UserAccountGettersAndSettersTrait;

    protected ?AddressBookPage $addressBook;
    protected ?CollectionInterface $paths;
    protected ?Modals $modals;
    protected ?CustomerEntity $customerEntity;

    public function __construct(?CustomerEntity $customerEntity = null, ?AddressBookPage $addressBook = null, ?Modals $modals = null, ?UserAccountPaths $paths = null)
    {
        $this->addressBook = $addressBook;
        $this->paths = $paths->Paths();
        $this->modals = $modals;
        $this->customerEntity = $customerEntity;
    }
}
