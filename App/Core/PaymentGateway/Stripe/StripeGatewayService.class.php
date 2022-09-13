<?php

declare(strict_types=1);

use Stripe\Customer;
use Stripe\Exception\ApiErrorException;
use Stripe\SetupIntent;
use Stripe\StripeClient;

class StripeGatewayService extends AbstractGatewayService implements PaymentGatewayInterface
{
    use StripeGetSetTrait;

    private StripeClient $stripe;
    private string $stripeSecret = STRIPE_KEY_SECRET;
    private SetupIntent $setupIntent;
    private SessionInterface $session;
    private CacheInterface $cache;
    private MoneyManager $money;
    private string $defaultCurrency = 'eur';
    private Customer $customer;
    private ?CustomerEntity $customerEntity;
    private ?CollectionInterface $paymentMethod;
    private ?string $customer_id;

    public function __construct(SessionInterface $session, CacheInterface $cache, ?string $customer_id = null, ?CustomerEntity $customerEntity = null, ?object $paymentMethod = null)
    {
        $this->stripe = new StripeClient($this->stripeSecret);
        $this->session = $session;
        $this->cache = $cache;
        $this->money = MoneyManager::getInstance();
        $this->customerEntity = $customerEntity;
        $this->customer_id = $customer_id;
        $this->paymentMethod = $paymentMethod;
    }

    public function createCustomer() : self
    {
        try {
            $this->customer = $this->stripe->customers->create([
                'description' => 'stripe Customer',
                'email' => $this->customerEntity->getEmail(),
                'name' => $this->customerEntity->getFirstName() . ' ' . $this->customerEntity->getLastName(),
                'phone' => $this->customerEntity->isInitialized('phone') ? $this->customerEntity->getPhone() : '',
                'payment_method' => $this->paymentMethod->offsetGet('id'),
            ]);
            $this->createCard();

            return $this;
        } catch (ApiErrorException $th) {
            throw new PaymentGatewayException($th->getMessage());
        }
    }

    public function createCard() : self
    {
        try {
            $this->stripe->customers->createSource($this->customer->id, [
                'source' => 'tok_' . $this->paymentMethod->offsetGet('card')['brand'],
            ]);

            return $this;
        } catch (ApiErrorException $th) {
            throw new PaymentGatewayException($th->getMessage());
        }
    }

    public function setupIntent() : self
    {
        try {
            $this->setupIntent = $this->stripe->setupIntents->create([
                'customer' => $this->customer->id,
                'payment_method_types' => ['bancontact', 'card', 'ideal'],
            ]);

            return $this;
        } catch (ApiErrorException $th) {
            throw new PaymentGatewayException($th->getMessage());
        }
    }

    public function retriveCustomer() : self
    {
        try {
            $cId = isset($this->customer_id) ? $this->customer_id : $this->customerEntity->getCustomerId();
            $this->customer = $this->stripe->customers->retrieve($cId);
            if (isset($this->paymentMethod)) {
                $this->createCard();
            }
            // $setup = $this->setupIntent();
            return $this;
        } catch (ApiErrorException $th) {
            throw new PaymentGatewayException($th->getMessage());
        }
    }

    public function getCards()
    {
        $cards = $this->stripe->customers->allSources($this->customer->id, ['object' => 'card', 'limit' => 3]);

        return $cards;
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
            $p = $this->paymentMethod->offsetGet('id');

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
