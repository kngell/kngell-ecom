<?php

declare(strict_types=1);

class UserCartController extends Controller
{
    protected string $url;

    public function add(array $args = [], ?string $link = null) : void
    {
        /** @var CartManager */
        $model = $this->model(CartManager::class)->assign($this->isValidRequest());
        if ($model->addUserItem()->count() === 1) {
            $link != null ? $this->setUrl($link) : '';
            $this->dispatcher->dispatch(new UserCartChangeEvent($this, '', ['displayUserCart']));
        }
        $this->jsonResponse(['result' => 'success', 'msg' => $link != null ? $link : ['nbItems' => 0]]);
    }

    public function qtyChange(array $args = []) : void
    {
        /** @var CartManager */
        $model = $this->model(CartManager::class)->assign($this->isValidRequest());
        $model = $this->updateQty($model);
        if ($model->save()) {
            $this->dispatcher->dispatch(new UserCartChangeEvent($this, '', ['shoppingCart']));
            // $this->cache->delete($this->cachedFiles['user_cart']);
            // $this->jsonResponse(['result' => 'success', 'msg' => $this->shoppingCart()['shoppingCart']]);
        }
        $this->jsonResponse(['result' => 'success', 'msg' => ['nbItems' => 0]]);
    }

    public function deleteItem(array $args = []) : void
    {
        /** @var CartManager */
        $model = $this->model(CartManager::class)->assign($this->isValidRequest());
        $shopping_cart = $this->selectItem($model);
        if ($shopping_cart->count() === 1) {
            $model->assign(['cart_id' => $shopping_cart->pop()->cart_id]);
            if ($model->delete()->count() === 1) {
                $this->dispatcher->dispatch(new UserCartChangeEvent($this, '', [
                    'displayUserCart',
                    'displayShoppingCart',
                ]));
            }
        }
        $this->jsonResponse(['result' => 'error', 'msg' => $this->helper->showMessage('warning', 'Something goes wrong!')]);
    }

    public function saveForLater(array $args = []) : void
    {
        /** @var CartManager */
        $model = $this->model(CartManager::class)->assign($this->isValidRequest());
        $shopping_cart = $this->selectItem($model);
        if ($shopping_cart->count() === 1) {
            $item = $shopping_cart->pop();
            $model->assign(['cart_id' => $item->cart_id]);
            if ($model->save()->count() === 1) {
                $this->dispatcher->dispatch(new UserCartChangeEvent($this, '', [
                    'displayUserCart',
                    'displayShoppingCart',
                ]));
            }
        }
    }

    public function buy(array $args) : void
    {
        $this->add($args, '/cart');
    }

    private function updateQty(CartManager $m) : CartManager
    {
        /** @var CollectionInterface */
        $shopping_cart = $this->getUserCart();
        /** @var CartEntity */
        $en = $m->getEntity();
        foreach ($shopping_cart as $item) {
            if ($item->item_id === $en->getItemId()) {
                $item->item_qty = $en->getItemQty();
                $m->assign(['cart_id' => $item->cart_id]);
            }
        }

        return $m;
    }
}
