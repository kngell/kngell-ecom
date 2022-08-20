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

    public function getSession() : SessionInterface;

    public function setSession(SessionInterface $session) : self;

    public function getCustomer() : Customer;

    public function setCustomer(Customer $customer) : self;

    public function getCustomerEntity() : CustomerEntity;

    public function setCustomerEntity(CustomerEntity $customerEntity) : self;

    public function getPaymentMethod() : ?CollectionInterface;

    public function setPaymentMethod(?CollectionInterface $paymentMethod) :self;

    public function getPaymentIntent() : PaymentIntent;

    public function setPaymentIntent(PaymentIntent $paymentIntent) : self;

    public function getMoney() : MoneyManager;

    public function setMoney(MoneyManager $money) : self;
}