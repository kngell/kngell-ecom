<?php

declare(strict_types=1);

class DisplayUserCart extends AbstractDisplayUserCart implements DisplayPagesInterface
{
    use DisplayTraits;

    public function __construct(CollectionInterface|closure $userCart, UserCartItemsForm $userCartForm)
    {
        list($userCart) = $this->invoke([$userCart]);
        parent::__construct($userCart, $userCartForm);
    }

    public function displayAll() : array
    {
        return ['cartItems' => $this->userCartForm->createForm('#', $this->userCart)];
    }
}