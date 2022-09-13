<?php

declare(strict_types=1);

trait DisplayFrontEndPagesTrait
{
    public function displayUerAccount(array $params = [], string $accountItem = '') : array
    {
        // $user_account_data = $this->getUserAccount($params);
        // if (AuthManager::isUserLoggedIn()) {
        $params = $this->userAccountOptions($params, $accountItem);
        return $this->container(UserAccountHomePage::class, ['params' => $params])->displayAll();
        // }
        // return [];
    }

    public function userAccountOptions(array $params = [], string $accountItem = '') : array
    {
        return array_merge(['customerEntity' => $this->getCustomerEntity()], match ($accountItem) {
            'orders' => $this->accountShowOrders($params),
            'profile' => ['profile' => $this->container(ShowProfile::class), 'params' => $params],
            'address' => ['showAddress' => $this->container(ShowAddress::class), 'params' => $params],
            'userCard' => ['userCard' => $this->container(ShowUserCard::class), 'params' => $params]
        });
    }

    public function accountShowOrders(array $params = []) : array
    {
        /** @var CollectionInterface */
        $orderList = $this->getOrderList($params);

        return [
            'showOrders' => $this->container(ShowOrders::class, [
                'orderList' => $orderList->filter(function ($obj, $key) {
                    return in_array($key, ['orders', 'order_details']);
                }),
            ]),
            'pagination' => $this->container(Pagination::class, $orderList->filter(function ($obj, $key) {
                return $key === 'params';
            })->all()),
            'params' => $params,
        ];
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

    public function displayLayout() : array
    {
        return array_merge(
            $this->container(DisplayAuthSystem::class)->displayAll(),
            $this->outputComments(),
            $this->container(
                Navigation::class,
                [
                    'settings' => $this->getSettings(),
                    'cartItem' => $this->displayUserCart(),
                    'view' => $this->view(),
                ]
            )->displayAll()
        );
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
            'customerEntity' => ($this->container(Customer::class)->get())->getEntity(),
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