<?php

declare(strict_types=1);

class ClearUserCartListener implements ListenerInterface
{
    public function __construct(private ContainerInterface $container)
    {
    }

    public function handle(EventsInterface $event): iterable
    {
        /** @var PaymentGatewayInterface */
        $object = $event->getObject();
        /** @var CheckoutPaymentsController */
        $ctrl = $event->getParams()[0];
        $saved_Items = $object->getCustomerEntity()->getCartSummary()->offsetGet('user_items');
        if (!empty($saved_Items)) {
            $delete = [];
            foreach ($saved_Items as $cartItem) {
                $delete[] = $this->clearDbCart($ctrl, $cartItem);
            }
            $cache = $this->deleteCache($ctrl, 'user_cart');
            return[$delete, $cache];
        }
        return [];
    }

    private function clearDbCart(CheckoutPaymentsController $ctrl, array $cartItem) : void
    {
        if (array_key_exists('id', $cartItem)) {
            $item = $ctrl->selectItem($cartItem['id']);
            if ($item->count() === 1) {
                $item = $item->pop();
                $delete[] = $this->container->make(CartManager::class)->assign(['cart_id' => $item->cart_id])->delete();
            }
        }
    }

    private function deleteCache(CheckoutPaymentsController $ctrl, string $cacheKey) : bool
    {
        if ($ctrl->getCache()->exists($ctrl->getCachedFiles()[$cacheKey])) {
            $cache = $ctrl->getCache()->delete($ctrl->getCachedFiles()[$cacheKey]);
            return true;
        }
        return false;
    }
}