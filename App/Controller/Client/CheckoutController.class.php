<?php

declare(strict_types=1);

class CheckoutController extends Controller
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
        $this->pageTitle('Checkout Page');
        $this->render('checkout' . DS . 'checkout', $this->checkoutPage());
    }
}