<?php

declare(strict_types=1);

class ShoppingCartController extends Controller
{
    public function __construct(array $params = [])
    {
        parent::__construct($params);
    }

    /**
     * IndexPage
     * ===================================================================.
     * @param array $data
     * @return void
     */
    protected function indexPage(array $data = []) : void
    {
        // $this->setLayout('clothes');
        // echo $this->route_params;
        $this->pageTitle('Shopping Cart');
        $this->render('shoppingCart' . DS . 'shoppingCart', $this->displayShoppingCart());
    }
}