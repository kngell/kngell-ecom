<?php

declare(strict_types=1);
class UpdateCustomerNavigationSessionListener implements ListenerInterface
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
}
