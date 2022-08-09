<?php

declare(strict_types=1);
class clearCustomerSessionListener implements ListenerInterface
{
    public function handle(EventsInterface $event): iterable
    {
        /** @var StripeGatewayService */
        $object = $event->getObject();
        $object->getSession()->delete(CHECKOUT_PROCESS_NAME);
        return [];
    }
}