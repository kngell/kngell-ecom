<?php

declare(strict_types=1);

abstract class AbstractDisplayUserCart
{
    protected CollectionInterface $userCart;
    protected UserCartItemsForm $userCartForm;

    public function __construct(CollectionInterface $userCart, UserCartItemsForm $userCartForm)
    {
        $this->userCart = $userCart;
        $this->userCartForm = $userCartForm;
    }

    /**
     * Get the value of userCart.
     */
    public function getUserCart() : CollectionInterface
    {
        return $this->userCart;
    }

    /**
     * Set the value of userCart.
     *
     * @return  self
     */
    public function setUserCart(CollectionInterface $userCart) : self
    {
        $this->userCart = $userCart;

        return $this;
    }
}
