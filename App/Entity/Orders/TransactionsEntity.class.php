<?php

declare(strict_types=1);

class TransactionsEntity extends Entity
{
    /** @id */
    private int $trId;
    private string $transactionId;
    private string $customerId;
    private string $orderId;
    private int $userId;
    private string $currency;
    private string $status;
    private DateTimeInterface $createdAt;
    private DateTimeInterface $updatedAt;

    public function __construct()
    {
        $this->createdAt = !isset($this->createdAt) ? new DateTimeImmutable() : $this->createdAt;
    }

    /**
     * Get the value of trId.
     */
    public function getTrId() : int
    {
        return $this->trId;
    }

    /**
     * Set the value of trId.
     *
     * @return  self
     */
    public function setTrId(int $trId) : self
    {
        $this->trId = $trId;

        return $this;
    }

    /**
     * Get the value of transactionId.
     */
    public function getTransactionId() : string
    {
        return $this->transactionId;
    }

    /**
     * Set the value of transactionId.
     *
     * @return  self
     */
    public function setTransactionId(string $transactionId) : self
    {
        $this->transactionId = $transactionId;

        return $this;
    }

    /**
     * Get the value of customerId.
     */
    public function getCustomerId() : string
    {
        return $this->customerId;
    }

    /**
     * Set the value of customerId.
     *
     * @return  self
     */
    public function setCustomerId(string $customerId) : self
    {
        $this->customerId = $customerId;

        return $this;
    }

    /**
     * Get the value of userId.
     */
    public function getUserId() : int
    {
        return $this->userId;
    }

    /**
     * Set the value of userId.
     *
     * @return  self
     */
    public function setUserId(int $userId) : self
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get the value of currency.
     */
    public function getCurrency() : string
    {
        return $this->currency;
    }

    /**
     * Set the value of currency.
     *
     * @return  self
     */
    public function setCurrency(string $currency) : self
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get the value of status.
     */
    public function getStatus() : string
    {
        return $this->status;
    }

    /**
     * Set the value of status.
     *
     * @return  self
     */
    public function setStatus(string $status) : self
    {
        $this->status = $status;

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

    /**
     * Get the value of orderId.
     */
    public function getOrderId(): string
    {
        return $this->orderId;
    }

    /**
     * Set the value of orderId.
     */
    public function setOrderId(string $orderId): self
    {
        $this->orderId = $orderId;

        return $this;
    }
}
