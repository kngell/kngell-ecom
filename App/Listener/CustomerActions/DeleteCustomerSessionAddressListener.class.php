<?php

declare(strict_types=1);
class DeleteCustomerSessionAddressListener implements ListenerInterface
{
    public function handle(EventsInterface $event): iterable
    {
        /** @var CheckoutProcessChangeController */
        $controller = $event->getObject();
        /** @var CustomerEntity */
        $customerEntity = unserialize($controller->getSession()->get(CHECKOUT_PROCESS_NAME));
        list($key, $address) = $this->addressToRemove($event, $customerEntity);
        $newAddresses = $this->deleteCustomerAddress($customerEntity, (string) $key);
        $customerEntity->setAddress($newAddresses);
        $controller->getSession()->set(CHECKOUT_PROCESS_NAME, serialize($customerEntity));
        return [];
    }

    protected function addressToRemove(EventsInterface $event, CustomerEntity $customerEntity) : array
    {
        /** @var AddressBookManager */
        $addressBook = $event->getParams()['addressBookManager'];
        /** @var AddressBookEntity */
        $addressEntity = $addressBook->getEntity();
        /** @var CollectionInterface */
        $currentAddresses = $customerEntity->getAddress();
        $addressToRemove = [];
        foreach ($currentAddresses as $key => $addr) {
            if ($addressEntity->isInitialized('ab_id') && $addr->ab_id === $addressEntity->getAbId()) {
                return $addressToRemove = [$key, $addr];
            }
        }
        return $addressToRemove;
    }

    protected function deleteCustomerAddress(CustomerEntity $customerEntity, string $key) : CollectionInterface
    {
        /** @var CollectionInterface */
        $currentAddresses = $customerEntity->getAddress();
        $currentAddresses->remove($key);
        return $currentAddresses;
    }
}