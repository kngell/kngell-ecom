<?php

declare(strict_types=1);
class ClearCustomerSessionListener implements ListenerInterface
{
    public function handle(EventsInterface $event): iterable
    {
        /** @var PaymentGatewayInterface */
        $object = $event->getParams()[0];
        if ($object->getSession()->exists(CHECKOUT_PROCESS_NAME)) {
            $object->getSession()->delete(CHECKOUT_PROCESS_NAME);
        }

        return [];
    }
}
