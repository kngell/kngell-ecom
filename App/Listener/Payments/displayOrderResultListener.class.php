<?php

declare(strict_types=1);
class displayOrderResultListener implements ListenerInterface
{
    public function handle(EventsInterface $event): iterable
    {
        /** @var StripeGatewayService */
        $object = $event->getObject();
        return [];
    }
}