<?php

declare(strict_types=1);

use Brick\Money\Money;

trait CheckoutGetterAndSetterTrait
{
    public function total() : string
    {
        return $this->cardSubTotal;
    }

    public function getTotalItem() : int
    {
        return $this->totalItems;
    }

    /**
     * Get the value of TTC.
     */
    public function getTTC() : Money
    {
        return isset($this->TTC) ? $this->TTC : '0';
    }

    /**
     * Get the value of cartItems.
     */
    public function getUserItems() : array
    {
        return $this->userItems;
    }

    /**
     * Set the value of cartItems.
     *
     * @return  self
     */
    public function setUserItems(array $userItems) : self
    {
        $this->userItems = $userItems;
        return $this;
    }

    /**
     * Get the value of HT.
     */
    public function getHT() : Money
    {
        return $this->HT;
    }

    /**
     * Set the value of HT.
     *
     * @return  self
     */
    public function setHT(Money $HT) : self
    {
        $this->HT = $HT;
        return $this;
    }

    /**
     * Get the value of finalTaxes.
     */
    public function getFinalTaxes() : CollectionInterface
    {
        return $this->finalTaxes;
    }

    /**
     * Set the value of finalTaxes.
     *
     * @return  self
     */
    public function setFinalTaxes(CollectionInterface $finalTaxes) : self
    {
        $this->finalTaxes = $finalTaxes;
        return $this;
    }
}