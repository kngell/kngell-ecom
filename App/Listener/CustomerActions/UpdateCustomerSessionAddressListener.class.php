<?php

declare(strict_types=1);
class UpdateCustomerSessionAddressListener implements ListenerInterface
{
    public function handle(EventsInterface $event): iterable
    {
        /** @var CheckoutProcessChangeController */
        $controller = $event->getObject();
        /** @var CustomerEntity */
        $customerEntity = unserialize($controller->getSession()->get(CHECKOUT_PROCESS_NAME));
        $address = $this->getCustomerAddressObject($event, $customerEntity);
        $newAddresses = $this->updateCustomerAddress($customerEntity, $address);
        $customerEntity->setAddress($newAddresses);
        $controller->getSession()->set(CHECKOUT_PROCESS_NAME, serialize($customerEntity));
        return [];
    }

    private function getCustomerAddressObject(EventsInterface $event, CustomerEntity $customerEntity) : ?object
    {
        return match ($event->getName()) {
            'CustomerAddressChangeEvent' => $this->addressFromDatabase($event, $customerEntity),
            default => $this->addressFromCustomerEntity($event, $customerEntity)
        };
    }

    private function addressFromCustomerEntity(EventsInterface $event, CustomerEntity $customerEntity)
    {
        $data = $event->getParams()['data'];
        $addrType = $data['addrType'];
        if ($customerEntity->isInitialized('address')) {
            $address = $customerEntity->getAddress()->filter(function ($addr) use ($data) {
                return $addr->ab_id === (int) $data['ab_id'];
            });
            $address = $address->pop();
            if ($addrType != '' && $addrType == 'delivery') {
                $address->principale = 'Y';
            } elseif ($addrType != '' && $addrType == 'billing') {
                $address->billing_addr = 'Y';
            }
            return $address;
        }
    }

    private function addressFromDatabase(EventsInterface $event, CustomerEntity $customerEntity)
    {
        /** @var AddressBookManager */
        $addressBook = $event->getParams()['addressBookManager'];
        /** @var AddressBookEntity */
        $addrEntity = $addressBook->getEntity();
        $data = $event->getParams()['data'];
        $id = $addressBook->getLastID() ?? $data['ab_id'];
        $addressBook = !$addrEntity->isInitialized('ab_id') ? $addressBook->assign(['ab_id' => $id]) : '';
        return (object) $addressBook->getEntity()->getInitializedAttributes();
    }

    private function updateCustomerAddress(CustomerEntity $customerEntity, object $newAddress) : CollectionInterface
    {
        /** @var CollectionInterface */
        $currentAddresses = $customerEntity->getAddress();
        if ($currentAddresses->valueExists($newAddress, 'ab_id')) {
            return $this->updateValue($newAddress, $currentAddresses);
        }
        return $this->addNewValue($newAddress, $currentAddresses);
    }

    private function addNewValue(object $newAddress, CollectionInterface $currentAddresses) : CollectionInterface
    {
        /** @var CollectionInterface */
        $add = new Collection([]);
        $currentAddresses = $this->updateSessionAddress($newAddress, $currentAddresses, 'principale');
        $currentAddresses = $this->updateSessionAddress($newAddress, $currentAddresses, 'billing_addr');
        foreach ($currentAddresses as $key => $address) {
            $add->add($address);
        }
        if (is_string($newAddress->pays)) {
            $newAddress->pays = Container::getInstance()->make(CountriesManager::class)->country($newAddress->pays);
        }
        $add->add($newAddress);
        return $add;
    }

    private function updateSessionAddress(object $newAddress, CollectionInterface $currentAddresses) : CollectionInterface
    {
        if ($newAddress->principale == 'Y') {
            /** @var CollectionInterface */
            $add = new Collection([]);
            foreach ($currentAddresses as $address) {
                if ($address->principale == 'Y') {
                    $address->principale = 'N';
                }
                $add->add($address);
            }
            return $add;
        }
        return $currentAddresses;
    }

    private function updateValue(object $newAddress, CollectionInterface $currentAddresses) : CollectionInterface
    {
        /** @var CollectionInterface */
        $add = new Collection([]);
        foreach ($currentAddresses->all() as $address) {
            property_exists($newAddress, 'principale') && $newAddress->principale === 'Y' && $newAddress->ab_id != $address->ab_id ? $address->principale = 'N' : '';
            property_exists($newAddress, 'billing_addr') && $newAddress->billing_addr == 'Y' && $newAddress->ab_id != $address->ab_id ? $address->billing_addr = 'N' : '';
            if ($address->ab_id === $newAddress->ab_id) {
                if (is_string($newAddress->pays)) {
                    $newAddress->pays = Container::getInstance()->make(CountriesManager::class)->country($newAddress->pays);
                }
                $add->add($newAddress);
            } else {
                $add->add($address);
            }
        }
        return $add;
    }
}