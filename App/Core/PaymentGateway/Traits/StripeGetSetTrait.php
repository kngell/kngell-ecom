<?php

declare(strict_types=1);

use Stripe\Customer;
use Stripe\PaymentIntent;
use Stripe\StripeClient;

trait StripeGetSetTrait
{
    /**
     * Get the value of stripe.
     */
    public function getStripe() : StripeClient
    {
        return $this->stripe;
    }

    /**
     * Set the value of stripe.
     *
     * @return  self
     */
    public function setStripe(StripeClient $stripe) : self
    {
        $this->stripe = $stripe;

        return $this;
    }

    /**
     * Get the value of session.
     */
    public function getSession() : SessionInterface
    {
        return $this->session;
    }

    /**
     * Set the value of session.
     *
     * @return  self
     */
    public function setSession(SessionInterface $session) : self
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Get the value of customer.
     */
    public function getCustomer() : Customer
    {
        return $this->customer;
    }

    /**
     * Set the value of customer.
     *
     * @return  self
     */
    public function setCustomer(Customer $customer) : self
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get the value of customerEntity.
     */
    public function getCustomerEntity() : CustomerEntity
    {
        return $this->customerEntity;
    }

    /**
     * Set the value of customerEntity.
     *
     * @return  self
     */
    public function setCustomerEntity(CustomerEntity $customerEntity) : self
    {
        $this->customerEntity = $customerEntity;

        return $this;
    }

    /**
     * Get the value of paymentMethod.
     */
    public function getPaymentMethod() : ?CollectionInterface
    {
        return $this->paymentMethod;
    }

    /**
     * Set the value of paymentMethod.
     *
     * @return  self
     */
    public function setPaymentMethod(?CollectionInterface $paymentMethod) :self
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    /**
     * Get the value of paymentIntent.
     */
    public function getPaymentIntent() : PaymentIntent
    {
        return $this->paymentIntent;
    }

    /**
     * Set the value of paymentIntent.
     *
     * @return  self
     */
    public function setPaymentIntent(PaymentIntent $paymentIntent) : self
    {
        $this->paymentIntent = $paymentIntent;

        return $this;
    }

    /**
     * Get the value of money.
     */
    public function getMoney() : MoneyManager
    {
        return $this->money;
    }

    /**
     * Set the value of money.
     *
     * @return  self
     */
    public function setMoney(MoneyManager $money) : self
    {
        $this->money = $money;

        return $this;
    }
}
