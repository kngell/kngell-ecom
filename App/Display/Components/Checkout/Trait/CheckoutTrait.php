<?php

declare(strict_types=1);

trait CheckoutTrait
{
    protected function properties(array $params = []) : void
    {
        if (!empty($params)) {
            foreach ($params as $key => $param) {
                if (property_exists($this, $key)) {
                    $this->{$key} = $param;
                }
            }
        }
    }

    protected function getShippingClassObj(CollectionInterface $shClass) : ?object
    {
        if ($shClass->count() > 0) {
            $shObj = $shClass->filter(function ($sh) {
                return $sh->default_shipping_class === '1';
            });
            if ($shObj->count() === 1) {
                return $shObj->pop();
            }
        }
        return null;
    }

    protected function shippingMethod(CollectionInterface $obj) : array
    {
        /** @var CollectionInterface */
        $shippingClassObj = $this->getShippingClassObj($obj);
        if (!is_null($shippingClassObj)) {
            return [
                'id' => (string) $shippingClassObj->shc_id,
                'name' => (string) $shippingClassObj->sh_name,
                'price' => (string) $shippingClassObj->price, ];
        }
        return [];
    }

    protected function sessionCart() : CollectionInterface
    {
        $cartSummary = new Collection([]);
        $cartSummary->offsetSet('cart_items', $this->cartSummary->getCartItems());
        $cartSummary->offsetSet('totalHT', $this->cartSummary->getHT());
        $cartSummary->offsetSet('totalTTC', $this->cartSummary->getTTC());
        $cartSummary->offsetSet('finalTaxes', $this->cartSummary->getFinalTaxes());
        return $cartSummary;
    }
}