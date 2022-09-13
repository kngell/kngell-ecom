<?php

declare(strict_types=1);

trait DatabaseCacheTrait
{
    public function getCachedData(string $fileName, array $cm = [], array $params = [], int $time = 20) : Object
    {
        if ((!is_array($cm) || !is_array($params)) || empty($cm)) {
            throw new BaseInvalidArgumentException('Paramètres collecte des données invalides', 1);
        }
        if (!$this->cache->exists($this->cachedFiles[$fileName] ?? $fileName)) {
            $this->cache->set($this->cachedFiles[$fileName] ?? $fileName, call_user_func_array($cm, !empty($params) ? $params : []), $time);
        }

        return $this->cache->get($this->cachedFiles[$fileName] ?? $fileName);
    }

    public function getUserCart() : CollectionInterface
    {
        return $this->getCachedData('user_cart', [$this->model(CartManager::class), 'getUserCart']);
    }

    public function getSettings() : object
    {
        return $this->getCachedData('settings', [$this->model(SettingsManager::class), 'getSettings']);
    }

    protected function getProducts(int $brand, ?string $cache) : CollectionInterface
    {
        return $this->getCachedData($cache, [$this->model(ProductsManager::class), 'getProducts'], [$brand]);
    }

    protected function getSingleProduct(?string $slug) : ?object
    {
        $cacheKey = StringUtil::studlyCaps($slug);

        return $this->getCachedData($cacheKey, [$this->model(ProductsManager::class), 'getSingleProduct'], [$slug], 20);
    }

    protected function getSliders() : CollectionInterface
    {
        return $this->getCachedData('sliders', [$this->model(SlidersManager::class), 'all']);
    }

    protected function getShippingClass() : CollectionInterface
    {
        return $this->getCachedData('shipping_class', [$this->model(ShippingClassManager::class), 'getShippingClass']);
    }

    protected function getOrderList(array $params = []) : CollectionInterface
    {
        if (AuthManager::isUserLoggedIn()) {
            return $this->container(OrdersManager::class)->assign([
                'ord_user_id' => $this->session->get(CURRENT_USER_SESSION_NAME)['id'],
            ])->AllWithSearchAndPagin($params);
        }

        return new Collection([]);
    }

    protected function getCustomerEntity() : CustomerEntity
    {
        $customer = $this->model(Customer::class)->get();
        if ($this->session->exists(CURRENT_USER_SESSION_NAME)) {
            return $this->getCachedData(
                'customer' . $this->session->get(CURRENT_USER_SESSION_NAME)['id'],
                [$customer, 'getEntity']
            );
        }
        return new CustomerEntity();
    }

    protected function getCustomerEntityFromSession() : ?CustomerEntity
    {
        if ($this->session->exists(CHECKOUT_PROCESS_NAME)) {
            return unserialize($this->session->get(CHECKOUT_PROCESS_NAME));
        }

        return null;
    }

    protected function getUserAccount(array $params = []) : ?UserAccount
    {
        if ($this->session->exists(CURRENT_USER_SESSION_NAME)) {
            $file = 'user_account' . $this->session->get(CURRENT_USER_SESSION_NAME)['id'];

            return $this->getCachedData($file, [$this->model(UserAccount::class), 'get'], [$params]);
        }

        return null;
    }
}