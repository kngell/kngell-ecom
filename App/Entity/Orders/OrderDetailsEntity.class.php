<?php

declare(strict_types=1);

class OrderDetailsEntity extends Entity
{
    /** @id */
    private int $odId;
    private int $odOrderId;
    private int $odProductId;
    private string $odPackingSize;
    private int $odQuantity;
    private string $odAmount;
    private string $odTaxAmount;
    private string $odPurchaseType;
    private string $odTaxDetails;
    private DateTimeInterface $createdAt;
    private DateTimeInterface $updatedAt;

    public function __construct()
    {
        $this->createdAt = !isset($this->createdAt) ? new DateTimeImmutable() : $this->createdAt;
    }

    /**
     * Get the value of odId.
     */
    public function getOdId(): int
    {
        return $this->odId;
    }

    /**
     * Set the value of odId.
     */
    public function setOdId(int $odId): self
    {
        $this->odId = $odId;

        return $this;
    }

    /**
     * Get the value of odOrderId.
     */
    public function getOdOrderId(): int
    {
        return $this->odOrderId;
    }

    /**
     * Set the value of odOrderId.
     */
    public function setOdOrderId(int $odOrderId): self
    {
        $this->odOrderId = $odOrderId;

        return $this;
    }

    /**
     * Get the value of odProductID.
     */
    public function getOdProductId(): int
    {
        return $this->odProductId;
    }

    /**
     * Set the value of odProductID.
     */
    public function setOdProductId(int $odProductID): self
    {
        $this->odProductId = $odProductID;

        return $this;
    }

    /**
     * Get the value of odPackingSize.
     */
    public function getOdPackingSize(): string
    {
        return $this->odPackingSize;
    }

    /**
     * Set the value of odPackingSize.
     */
    public function setOdPackingSize(string $odPackingSize): self
    {
        $this->odPackingSize = $odPackingSize;

        return $this;
    }

    /**
     * Get the value of odQuantity.
     */
    public function getOdQuantity(): int
    {
        return $this->odQuantity;
    }

    /**
     * Set the value of odQuantity.
     */
    public function setOdQuantity(int $odQuantity): self
    {
        $this->odQuantity = $odQuantity;

        return $this;
    }

    /**
     * Get the value of odAmount.
     */
    public function getOdAmount(): string
    {
        return $this->odAmount;
    }

    /**
     * Set the value of odAmount.
     */
    public function setOdAmount(string $odAmount): self
    {
        $this->odAmount = $odAmount;

        return $this;
    }

    /**
     * Get the value of odTaxAmount.
     */
    public function getOdTaxAmount(): string
    {
        return $this->odTaxAmount;
    }

    /**
     * Set the value of odTaxAmount.
     */
    public function setOdTaxAmount(string $odTaxAmount): self
    {
        $this->odTaxAmount = $odTaxAmount;

        return $this;
    }

    /**
     * Get the value of odPurchaseType.
     */
    public function getOdPurchaseType(): string
    {
        return $this->odPurchaseType;
    }

    /**
     * Set the value of odPurchaseType.
     */
    public function setOdPurchaseType(string $odPurchaseType): self
    {
        $this->odPurchaseType = $odPurchaseType;

        return $this;
    }

    /**
     * Get the value of createdAt.
     */
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt.
     */
    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of updatedAt.
     */
    public function getUpdatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt.
     */
    public function setUpdatedAt(DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get the value of odTaxDetails.
     */
    public function getOdTaxDetails(): string
    {
        return $this->odTaxDetails;
    }

    /**
     * Set the value of odTaxDetails.
     */
    public function setOdTaxDetails(string $odTaxDetails): self
    {
        $this->odTaxDetails = $odTaxDetails;

        return $this;
    }
}
