<?php

declare(strict_types=1);
class saveOrderDetailsListener implements ListenerInterface
{
    public function handle(EventsInterface $event): iterable
    {
        /** @var StripeGatewayService */
        $object = $event->getObject();
        $model = Container::getInstance()->make(TransactionsManager::class)->assign([
            'transaction_id' => $object->getPaymentIntent()->id,
            'customer_id' => $object->getPaymentIntent()->customer,
            'user_id' => $object->getCustomerEntity()->getUserId(),
            'delivery_address' => $object->getCustomerEntity()->getAddress()->filter(function ($addr) {
                return $addr->principale == 1;
            })->pop()->ab_id,
            'billing_address' => $object->getCustomerEntity()->getAddress()->filter(function ($addr) {
                return $addr->billing_addr == 'on';
            })->pop()->ab_id,
            'order_ttc' => strval($object->getMoney()->intFromMoney($object->getCustomerEntity()->getCartSummary()->offsetGet('totalTTC'))),
            'order_ht' => strval($object->getMoney()->intFromMoney($object->getCustomerEntity()->getCartSummary()->offsetGet('totalHT'))),
            'taxes' => serialize($object->getCustomerEntity()->getCartSummary()->offsetGet('finalTaxes')),
            'currency' => $object->getPaymentIntent()->currency,
            'status' => $object->getPaymentIntent()->status,
        ])->save();
        return [$model];
    }
}