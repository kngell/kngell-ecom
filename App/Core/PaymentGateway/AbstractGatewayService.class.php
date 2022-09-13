<?php

declare(strict_types=1);

use Stripe\PaymentIntent;

abstract class AbstractGatewayService
{
    protected PaymentIntent $paymentIntent;

    public function ok() : bool
    {
        if ($this->paymentIntent->status === 'succeeded') {
            return true;
        }

        return false;
    }
}
