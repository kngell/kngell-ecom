<?php

declare(strict_types=1);

class UserAccountEntity extends Entity
{
    private CollectionInterface $profile;
    private CollectionInterface $address;
    private CollectionInterface $orders;
    private CollectionInterface $paymentMode;

    /**
     * Get the value of profile.
     */
    public function getProfile(): CollectionInterface
    {
        return $this->profile;
    }

    /**
     * Set the value of profile.
     */
    public function setProfile(CollectionInterface $profile): self
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Get the value of address.
     */
    public function getAddress(): CollectionInterface
    {
        return $this->address;
    }

    /**
     * Set the value of address.
     */
    public function setAddress(CollectionInterface $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get the value of orders.
     */
    public function getOrders(): CollectionInterface
    {
        return $this->orders;
    }

    /**
     * Set the value of orders.
     */
    public function setOrders(CollectionInterface $orders): self
    {
        $this->orders = $orders;

        return $this;
    }

    /**
     * Get the value of paymentMode.
     */
    public function getPaymentMode(): CollectionInterface
    {
        return $this->paymentMode;
    }

    /**
     * Set the value of paymentMode.
     */
    public function setPaymentMode(CollectionInterface $paymentMode): self
    {
        $this->paymentMode = $paymentMode;

        return $this;
    }
}
