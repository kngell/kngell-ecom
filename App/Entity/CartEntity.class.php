<?php

declare(strict_types=1);

class CartEntity extends Entity
{
    /** @id */
    private int $cartId;
    private string $userId;
    private int $itemId;
    private int $itemQty;
    private string $totalAmount;
    private string $cartType;
    private DateTimeInterface $createdAt;
    private DateTimeInterface $updatedAt;

    public function __construct()
    {
        $this->createdAt = !isset($this->createdAt) ? new DateTimeImmutable() : $this->createdAt;
    }

    /**
     * Get the value of cartId.
     */
    public function getCartId() : int
    {
        return $this->cartId;
    }

    /**
     * Set the value of cartId.
     *
     * @return  self
     */
    public function setCartId(int $cartId) : self
    {
        $this->cartId = $cartId;
        return $this;
    }

    /**
     * Get the value of userId.
     */
    public function getUserId() : string
    {
        return $this->userId;
    }

    /**
     * Set the value of userId.
     *
     * @return  self
     */
    public function setUserId(string $userId) : self
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * Get the value of itemId.
     */
    public function getItemId() : int
    {
        return $this->itemId;
    }

    /**
     * Set the value of itemId.
     *
     * @return  self
     */
    public function setItemId(int $itemId) : self
    {
        $this->itemId = $itemId;
        return $this;
    }

    /**
     * Get the value of itemQty.
     */
    public function getItemQty() : int
    {
        return $this->itemQty;
    }

    /**
     * Set the value of itemQty.
     *
     * @return  self
     */
    public function setItemQty(int $itemQty) : self
    {
        $this->itemQty = $itemQty;
        return $this;
    }

    /**
     * Get the value of totalAmount.
     */
    public function getTotalAmount() : string
    {
        return $this->totalAmount;
    }

    /**
     * Set the value of totalAmount.
     *
     * @return  self
     */
    public function setTotalAmount(string $totalAmount) : self
    {
        $this->totalAmount = $totalAmount;
        return $this;
    }

    /**
     * Get the value of cartType.
     */
    public function getCartType() : string
    {
        return $this->cartType;
    }

    /**
     * Set the value of cartType.
     *
     * @return  self
     */
    public function setCartType(string $cartType) : self
    {
        $this->cartType = $cartType;
        return $this;
    }

    /**
     * Get the value of createdAt.
     */
    public function getCreatedAt() : DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt.
     *
     * @return  self
     */
    public function setCreatedAt(DateTimeInterface $createdAt) : self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Get the value of updatedAt.
     */
    public function getUpdatedAt() : DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt.
     *
     * @return  self
     */
    public function setUpdatedAt(DateTimeInterface $updatedAt) : self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function delete(?string $field = null) : self
    {
        if (isset($this->$field)) {
            unset($this->$field);
        }
        return $this;
    }
}