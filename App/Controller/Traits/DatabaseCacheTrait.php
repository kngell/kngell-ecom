<?php

declare(strict_types=1);

trait DatabaseCacheTrait
{
    public function getUserCart(?CartManager $m = null) : CollectionInterface
    {
        if (!$this->cache->exists($this->cachedFiles['user_cart'])) {
            $model = $m == null ? $this->model(CartManager::class) : $m;
            $this->cache->set($this->cachedFiles['user_cart'], $model->getUserCart());
        }
        return $this->cache->get($this->cachedFiles['user_cart']);
    }

    public function getSettings() : object
    {
        if (!$this->cache->exists('settings')) {
            $this->cache->set('settings', $this->container(SettingsManager::class)->getSettings());
        }
        return $this->cache->get('settings');
    }

    protected function getProducts(int $brand, ?string $cache) : CollectionInterface
    {
        if (!$this->cache->exists($this->cachedFiles[$cache])) {
            $this->cache->set($this->cachedFiles[$cache], $this->model(ProductsManager::class)->getProducts($brand));
        }
        return $this->cache->get($this->cachedFiles[$cache]);
    }

    protected function getSingleProduct(?string $slug) : ?object
    {
        $cacheKey = Stringify::studlyCaps($slug);
        if (!$this->cache->exists($cacheKey)) {
            $this->cache->set($cacheKey, $this->model(ProductsManager::class)->getSingleProduct($slug), 20);
        }
        return $this->cache->get($cacheKey);
    }

    protected function getSliders() : CollectionInterface
    {
        if (!$this->cache->exists($this->cachedFiles['sliders'])) {
            $this->cache->set($this->cachedFiles['sliders'], $this->model(SlidersManager::class)->all());
        }
        return $this->cache->get($this->cachedFiles['sliders']);
    }

    protected function getShippingClass(?ShippingClassManager $m = null) : CollectionInterface
    {
        $model = $m == null ? $this->model(ShippingClassManager::class) : $m;
        if (!$this->cache->exists($this->cachedFiles['shipping_class'])) {
            $this->cache->set($this->cachedFiles['shipping_class'], $model->getShippingClass());
        }
        return $this->cache->get($this->cachedFiles['shipping_class']);
    }

    protected function getOrderList(array $params = [])
    {
        return $this->container(OrdersManager::class)->assign([
            'ord_user_id' => $this->session->get(CURRENT_USER_SESSION_NAME)['id'],
        ])->AllWithSearchAndPagin($params);
    }
}