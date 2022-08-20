<?php

declare(strict_types=1);
class SaveOrderDetailsListener implements ListenerInterface
{
    public function __construct(private DateTimeManager $dt, private ContainerInterface $container)
    {
    }

    public function handle(EventsInterface $event): iterable
    {
        /** @var PaymentGatewayInterface */
        $object = $event->getObject();
        $orders = $this->container->make(OrdersManager::class)->assign($this->orderData($object))->save();
        $tr = $this->container->make(TransactionsManager::class)->assign($this->transactionData($object))->save();
        $user_cart = $object->getCustomerEntity()->getCartSummary()->offsetGet('user_items');
        /** @var OrderDetailsManager */
        $odManager = $this->container->make(OrderDetailsManager::class);
        $od = [];
        foreach ($user_cart as $cartItem) {
            $od[] = $odManager->assign($this->orderDetailsData($object, $cartItem, $orders))->save();
        }
        return [$orders, $tr, $od];
    }

    private function orderDetailsData(PaymentGatewayInterface $object, array $cartItem, OrdersManager $orders) : array
    {
        list($taxeAmount, $taxeDetails) = $this->calcTaxes($cartItem);
        return [
            'od_order_id' => $orders->getLastID(),
            'od_product_id' => $cartItem['id'],
            'od_quantity' => $cartItem['item_qty'],
            'od_amount' => $cartItem['HT'],
            'od_tax_amount' => $object->getMoney()->getIntAmount(strval($taxeAmount)),
            'od_tax_details' => serialize($taxeDetails),
            'od_purchase_type' => '',
            'updated_at' => $this->dt->getFromInterface(new DateTime()),
        ];
    }

    private function calcTaxes(array $cartItem = []) : array
    {
        if (array_key_exists('taxes', $cartItem) && array_key_exists('HT', $cartItem)) {
            /** @var CollectionInterface */
            $taxes = $cartItem['taxes'];
            $taxeAmount = 0;
            $taxeDetails = [];
            foreach ($taxes as $taxObj) {
                $taxeAmount += ($cartItem['HT'] * $taxObj->t_rate) / 100;
                $taxeDetails[$taxObj->t_class] = ['title' => $taxObj->t_name, 'rate' => $taxObj->t_rate];
            }
            return [$taxeAmount, $taxeDetails];
        }
        throw new BaseException('Unable to calculate taxes for the product!', 1);
    }

    private function transactionData(PaymentGatewayInterface $object) : array
    {
        return [
            'transaction_id' => $object->getPaymentIntent()->id,
            'customer_id' => $object->getPaymentIntent()->customer,
            'order_id' => $object->getCustomerEntity()->getOrderId(),
            'user_id' => $object->getCustomerEntity()->getUserId(),
            'currency' => $object->getPaymentIntent()->currency,
            'status' => $object->getPaymentIntent()->status,
        ];
    }

    private function orderData(PaymentGatewayInterface $obj) : array
    {
        return [
            'ord_number' => $obj->getCustomerEntity()->getOrderId(),
            'ord_user_id' => $obj->getCustomerEntity()->getUserId(),
            'ord_pmt_mode' => $obj->getPaymentMethod()->offsetGet('type'),
            'ord_pay_transaction_Id' => $obj->getPaymentIntent()->id,
            'ord_delivery_address' => $obj->getCustomerEntity()->getAddress()->filter(function ($addr) {
                return $addr->principale == 'Y';
            })->pop()->ab_id,
            'ord_invoice_address' => $obj->getCustomerEntity()->getAddress()->filter(function ($addr) {
                return $addr->billing_addr == 'Y';
            })->pop()->ab_id,
            'ord_amount_ht' => strval($obj->getMoney()->intFromMoney($obj->getCustomerEntity()->getCartSummary()->offsetGet('totalHT'))),
            'ord_amount_ttc' => strval($obj->getMoney()->intFromMoney($obj->getCustomerEntity()->getCartSummary()->offsetGet('totalTTC'))),
            'ord_tax' => json_encode($obj->getCustomerEntity()->getCartSummary()->offsetGet('finalTaxes')->all()),
            'ord_qty' => $obj->getCustomerEntity()->getCartSummary()->offsetGet('totalItem'),
            'ord_delivery_date' => $this->dt->getFromInterface(new DateTime()),
            'ord_shipping_class' => $obj->getCustomerEntity()->getShippingMethod()['id'],
            'ord_status' => 1,
            'ord_pmt_status' => $obj->getPaymentIntent()->status,
            'updated_at' => $this->dt->getFromInterface(new DateTime()),
        ];
    }
}