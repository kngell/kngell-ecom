<?php

declare(strict_types=1);

class ShippingClassEntity extends Entity
{
    /** @id */
    private int $shcId;
    private int $shCompId;
    private string $shName;
    private string $shDescr;
    private string $status;
    private string $price;
    private int $deliveryLeadTime;
    private string $defaultShippingClass;
    private DateTimeInterface $createdAt;
    private DateTimeInterface $updatedAt;

    public function __construct()
    {
        $this->createdAt = !isset($this->createdAt) ? new DateTimeImmutable() : $this->createdAt;
    }

    /**
     * Get the value of shcId.
     */
    public function getShcId() : int
    {
        return $this->shcId;
    }

    /**
     * Set the value of shcId.
     *
     * @return  self
     */
    public function setShcId(int $shcId) : self
    {
        $this->shcId = $shcId;

        return $this;
    }

    /**
     * Get the value of shCompId.
     */
    public function getShCompId() : int
    {
        return $this->shCompId;
    }

    /**
     * Set the value of shCompId.
     *
     * @return  self
     */
    public function setShCompId(int $shCompId) : self
    {
        $this->shCompId = $shCompId;

        return $this;
    }

    /**
     * Get the value of shName.
     */
    public function getShName() : string
    {
        return $this->shName;
    }

    /**
     * Set the value of shName.
     *
     * @return  self
     */
    public function setShName(string $shName) : self
    {
        $this->shName = $shName;

        return $this;
    }

    /**
     * Get the value of shDescr.
     */
    public function getShDescr() : string
    {
        return $this->shDescr;
    }

    /**
     * Set the value of shDescr.
     *
     * @return  self
     */
    public function setShDescr(string $shDescr) : self
    {
        $this->shDescr = $shDescr;

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
     * Get the value of price.
     */
    public function getPrice() : string
    {
        return $this->price;
    }

    /**
     * Set the value of price.
     *
     * @return  self
     */
    public function setPrice(string $price) : self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of deliveryLeadTime.
     */
    public function getDeliveryLeadTime() : int
    {
        return $this->deliveryLeadTime;
    }

    /**
     * Set the value of deliveryLeadTime.
     *
     * @return  self
     */
    public function setDeliveryLeadTime(int $deliveryLeadTime) : self
    {
        $this->deliveryLeadTime = $deliveryLeadTime;

        return $this;
    }

    /**
     * Get the value of defaultShippingClass.
     */
    public function getDefaultShippingClass() : string
    {
        return $this->defaultShippingClass;
    }

    /**
     * Set the value of defaultShippingClass.
     *
     * @return  self
     */
    public function setDefaultShippingClass(string $defaultShippingClass) : self
    {
        $this->defaultShippingClass = $defaultShippingClass;

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
