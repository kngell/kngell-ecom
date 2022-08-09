<?php

declare(strict_types=1);

use Stripe\Customer;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

class StripeGatewayService extends AbstractGatewayService implements PaymentGatewayInterface
{
    use StripeGetSetTrait;

    private StripeClient $stripe;
    private string $stripeSecret = STRIPE_KEY_SECRET;
    private SessionInterface $session;
    private MoneyManager $money;
    private string $defaultCurrency = 'eur';
    private Customer $customer;
    private CustomerEntity $customerEntity;
    private ?CollectionInterface $paymentMethod;

    public function __construct(SessionInterface $session, ?object $paymentMethod = null)
    {
        $this->stripe = new StripeClient($this->stripeSecret);
        $this->session = $session;
        $this->money = MoneyManager::getInstance();
        $this->customerEntity = unserialize($this->session->get(CHECKOUT_PROCESS_NAME));
        $this->paymentMethod = $paymentMethod;
    }

    public function customer() : self
    {
        try {
            $this->customer = $this->stripe->customers->create([
                'description' => 'stripe Customer',
                'email' => $this->customerEntity->getEmail(),
                'name' => $this->customerEntity->getFirstName() . ' ' . $this->customerEntity->getLastName(),
                'phone' => $this->customerEntity->getPhone(),
                'payment_method' => $this->paymentMethod->offsetGet('id'),
            ]);
            return $this;
        } catch (ApiErrorException $th) {
            throw new PaymentGatewayException($th->getMessage());
        }
    }

    public function createPayment(): ?self
    {
        try {
            $this->paymentIntent = $this->stripe->paymentIntents->create([
                'amount' => $this->money->intFromMoney($this->customerEntity->getCartSummary()->offsetGet('totalTTC')),
                'currency' => $this->defaultCurrency,
                'payment_method_types' => [$this->paymentMethod->offsetGet('type')],
                'customer' => $this->customer->id,
                'payment_method' => $this->paymentMethod->offsetGet('id'),
                'confirmation_method' => 'manual',
            ]);
            return $this;
        } catch (ApiErrorException $th) {
            throw new PaymentGatewayException($th->getMessage());
        }
    }

    public function confirmPayment(): ?self
    {
        try {
            $this->paymentIntent = $this->stripe->paymentIntents->retrieve($this->paymentIntent->id)->confirm();
            return $this;
        } catch (ApiErrorException $th) {
            throw new PaymentGatewayException($th->getMessage());
        }
    }
}