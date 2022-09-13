<?php

declare(strict_types=1);

use Stripe\Customer;
use Stripe\PaymentIntent;

interface PaymentGatewayInterface
{
    /**
     * Create Payment Intent
     * --------------------------------------------------------------------------------------------------.
     *
     * @return object
     */
    public function createPayment() : ?self;

    /**
     * Confirm Payment Intent
     * --------------------------------------------------------------------------------------------------.
     * @return object
     */
    public function confirmPayment() : ?self;

    public function retriveCustomer() : self;

    public function getCards();

    public function getCustomerEntity() : CustomerEntity;

    public function getMoney() : MoneyManager;

    public function getPaymentIntent() : PaymentIntent;

    public function getPaymentMethod() : ?CollectionInterface;

    public function getSession() : SessionInterface;

    public function getCustomer() : Customer;
}
