<?php

declare(strict_types=1);

trait HomeControllerTrait
{
    private function displayProducts() : array
    {
        return $this->container(DisplayPhonesInterface::class, [
            'products' => function () {
                if (!$this->cache->exists($this->cachedFiles['phones_products'])) {
                    $this->cache->set($this->cachedFiles['phones_products'], $this->model(ProductsManager::class)->getProducts());
                }
                return $this->cache->get($this->cachedFiles['phones_products']);
            },
            'userCart' => $this->container(DisplayUserCart::class, [
                'userCart' => function () {
                    if (!$this->cache->exists($this->cachedFiles['user_cart'])) {
                        $this->cache->set($this->cachedFiles['user_cart'], $this->model(CartManager::class)->getUserCart());
                    }
                    return $this->cache->get($this->cachedFiles['user_cart']);
                },
            ]),
        ])->displayAll();
    }

    private function homePage() : array
    {
        return $this->container(CheckoutPage::class, [
            'userCart' => function () {
                if (!$this->cache->exists($this->cachedFiles['user_cart'])) {
                    $this->cache->set($this->cachedFiles['user_cart'], $this->model(CartManager::class)->getUserCart());
                }
                return $this->cache->get($this->cachedFiles['user_cart']);
            },
            'shippingClass' => function () {
                if (!$this->cache->exists($this->cachedFiles['shipping_class'])) {
                    $this->cache->set($this->cachedFiles['shipping_class'], $this->model(ShippingClassManager::class)->getShippingClass());
                }
                return $this->cache->get($this->cachedFiles['shipping_class']);
            },
            'pmtMode' => function () {
                if (!$this->cache->exists($this->cachedFiles['paiement_mode'])) {
                    $this->cache->set($this->cachedFiles['paiement_mode'], $this->model(PaymentModeManager::class)->all());
                }
                return $this->cache->get($this->cachedFiles['paiement_mode']);
            },
        ])->displayAll();
    }
}