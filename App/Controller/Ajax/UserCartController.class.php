<?php

declare(strict_types=1);

class UserCartController extends Controller
{
    public function add(array $args = []) : void
    {
        /** @var CartManager */
        $model = $this->model(CartManager::class)->assign($this->isValidRequest());
        if ($resp = $model->addUserItem()) {
            $this->dispatcher->dispatch(new UserCartChangeEvent($this));
            $this->jsonResponse(['result' => 'success', 'msg' => $resp]);
        }
        $this->jsonResponse(['result' => 'success', 'msg' => ['nbItems' => 0]]);
    }
}