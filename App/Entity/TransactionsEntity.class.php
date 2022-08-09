<?php

declare(strict_types=1);

class TransactionsEntity extends Entity
{
    /** @id */
    private int $trId;
    private string $transactionId;
    private string $customerId;
    private int $userId;
    private int $deliveryAddress;
    private int $billingAddress;
    private string $orderId;
    private string $orderTtc;
    private string $orderHt;
    private string $taxes;
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
     * Get the value of deliveryAddress.
     */
    public function getDeliveryAddress() : int
    {
        return $this->deliveryAddress;
    }

    /**
     * Set the value of deliveryAddress.
     *
     * @return  self
     */
    public function setDeliveryAddress(int $deliveryAddress) : self
    {
        $this->deliveryAddress = $deliveryAddress;
        return $this;
    }

    /**
     * Get the value of billingAddress.
     */
    public function getBillingAddress() : int
    {
        return $this->billingAddress;
    }

    /**
     * Set the value of billingAddress.
     *
     * @return  self
     */
    public function setBillingAddress(int $billingAddress) : self
    {
        $this->billingAddress = $billingAddress;
        return $this;
    }

    /**
     * Get the value of orderId.
     */
    public function getOrderId() : string
    {
        return $this->orderId;
    }

    /**
     * Set the value of orderId.
     *
     * @return  self
     */
    public function setOrderId(string $orderId) : self
    {
        $this->orderId = $orderId;
        return $this;
    }

    /**
     * Get the value of orderTtc.
     */
    public function getOrderTtc() : string
    {
        return $this->orderTtc;
    }

    /**
     * Set the value of orderTtc.
     *
     * @return  self
     */
    public function setOrderTtc(string $orderTtc) : self
    {
        $this->orderTtc = $orderTtc;
        return $this;
    }

    /**
     * Get the value of orderHt.
     */
    public function getOrderHt() : string
    {
        return $this->orderHt;
    }

    /**
     * Set the value of orderHt.
     *
     * @return  self
     */
    public function setOrderHt(string $orderHt) : self
    {
        $this->orderHt = $orderHt;
        return $this;
    }

    /**
     * Get the value of taxes.
     */
    public function getTaxes() : string
    {
        return $this->taxes;
    }

    /**
     * Set the value of taxes.
     *
     * @return  self
     */
    public function setTaxes(string $taxes) : self
    {
        $this->taxes = $taxes;
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
}