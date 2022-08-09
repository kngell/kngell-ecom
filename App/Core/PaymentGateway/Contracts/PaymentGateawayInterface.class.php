<?php

declare(strict_types=1);

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
}