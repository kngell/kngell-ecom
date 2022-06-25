<?php

declare(strict_types=1);

trait HomeControllerTrait
{
    private function displayProducts() : array
    {
        return $this->container(DisplayPhonesInterface::class, [
            'products' => function ($products) {
                if (!$this->cache->exists($this->cachedFiles['phones_products'])) {
                    return $this->cache->set($this->cachedFiles['phones_products'], $products->getProducts());
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
        ])->displayAll();
    }
}