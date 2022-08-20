<?php

declare(strict_types=1);

trait MethodsForDisplayingPageTrait
{
    public function displayUerAccount(array $params = []) : array
    {
        return $this->container(UserAccountHomePage::class, [
            'orderList' => $this->getOrderList($params),
        ])->displayAll();
    }

    public function displayUserCart() : array
    {
        return  $this->container(DisplayUserCart::class, [
            'userCart' => function () {
                return $this->getUserCart();
            },
        ])->displayAll();
    }

    public function displayShoppingCart() : array
    {
        return $this->container(ShoppingCartPage::class, [
            'cartItems' => $this->getUserCart(),
        ])->displayAll();
    }

    protected function displayCheckoutPage() : array
    {
        return $this->container(CheckoutPage::class, [
            'userCart' => $this->getUserCart(),
            'shippingClass' => $this->getShippingClass(),
            'pmtMode' => function () {
                if (!$this->cache->exists($this->cachedFiles['paiement_mode'])) {
                    $this->cache->set($this->cachedFiles['paiement_mode'], $this->model(PaymentModeManager::class)->all());
                }
                return $this->cache->get($this->cachedFiles['paiement_mode']);
            },
            'customer' => $this->container(Customer::class)->get(),
        ])->displayAll();
    }

    protected function displayPhones(int $brand = 2, ?string $cache = null) : array
    {
        return $this->container(DisplayPhonesInterface::class, [
            'products' => $this->getProducts(brand: $brand, cache: $cache),
            'userCart' => $this->container(DisplayUserCart::class, [
                'userCart' => $this->getUserCart(),
            ]),
            'slider' => $this->getSliders(),
        ])->displayAll();
    }

    protected function displayClothes(int $brand = 3, ?string $cache = null) : array
    {
        return $this->container(ClothesHomePage::class, [
            'products' => $this->getProducts(brand: $brand, cache: $cache),
            'userCart' => $this->container(DisplayUserCart::class, [
                'userCart' => $this->getUserCart(),
            ]),
            'slider' => $this->getSliders(),
        ])->displayAll();
    }

    protected function displayClothesShop(int $brand = 3, ?string $cache = null) : array
    {
        return $this->container(ClothesShopPage::class, [
            'products' => $this->getProducts(brand: $brand, cache: $cache),
            'userCart' => $this->container(DisplayUserCart::class, [
                'userCart' => $this->getUserCart(),
            ]),
            'slider' => $this->getSliders(),
        ])->displayAll();
    }
}