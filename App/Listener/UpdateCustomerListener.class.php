<?php

declare(strict_types=1);

class UpdateCustomerListener implements ListenerInterface
{
    public function handle(EventsInterface $event) : iterable
    {
        $object = $event->getObject();
        /** @var CustomerEntity */
        $customerEntity = unserialize($object->getSession()->get(CHECKOUT_PROCESS_NAME));
        return ['RegisterTo newLetter'];
    }
}