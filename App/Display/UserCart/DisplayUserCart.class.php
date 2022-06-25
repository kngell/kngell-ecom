<?php

declare(strict_types=1);

class DisplayUserCart extends AbstractDisplayUserCart
{
    public function __construct(CollectionInterface|closure $userCart, UserCartItemsForm $userCartForm)
    {
        if ($userCart instanceof Closure) {
            $userCart = $userCart->__invoke();
        }
        parent::__construct($userCart, $userCartForm);
    }

    public function userCartItems() : array
    {
        return ['cartItems' => $this->userCartForm->createForm('#', $this->userCart)];
    }
}