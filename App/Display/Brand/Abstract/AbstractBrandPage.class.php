<?php

declare(strict_types=1);

abstract class AbstractBrandPage
{
    use DisplayTraits;
    protected CollectionInterface|closure $products;
    protected ?object $product;
    protected ?FormBuilder $frm;
    protected ?object $userCart;
    protected ?CollectionInterface $paths;
    protected ?MoneyManager $money = null;
    protected ?CollectionInterface $slider;
    protected CookieInterface $cookie;

    public function __construct(array $params = [])
    {
        $this->properties($params);
    }

    protected function slider() : ?object
    {
        if ($this->slider->count() === 1) {
            return $this->slider->pop();
        }
        return null;
    }
}