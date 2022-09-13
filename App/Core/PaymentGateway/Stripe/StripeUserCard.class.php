<?php

declare(strict_types=1);

use Stripe\Stripe;
use Stripe\StripeClient;

class StripeUserCard
{
    private StripeClient $stripe;
    private string $stripeSecret = STRIPE_KEY_SECRET;
    private string $customer_id;

    public function __construct(string $customer_id)
    {
        $this->stripe = Stripe::setApiKey($this->stripeSecret);
        $this->customer_id = $customer_id;
    }

    public function setupIntent()
    {
        $intent = $this->stripe->setupIntents->create();

        return $intent->jsonSerialize();
    }
}
