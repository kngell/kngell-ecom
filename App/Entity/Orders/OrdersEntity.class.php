<?php

declare(strict_types=1);

class OrdersEntity extends Entity
{
    /** @id */
    private int $ordId;
    private string $ordNumber;
    private int $ordUserId;
    private string $ordPmtMode;
    private int $ordPayTransactionId;
    private int $ordDeliveryAddress;
    private string $ordInvoiceAddress;
    private string $ordAmountHt;
    private string $ordAmountTtc;
    private string $ordTax;
    private int $ordQty;
    private DateTimeInterface $ordDeliveryDate;
    private string $ordShippingClass;
    private int $ordStatus;
    private string $ordPmtStatus;
    private DateTimeInterface $createdAt;
    private DateTimeInterface $updatedAt;
    private int $deleted;

    public function __construct()
    {
        $this->createdAt = !isset($this->createdAt) ? new DateTimeImmutable() : $this->createdAt;
    }

    /**
     * Get the value of ordId.
     */
    public function getOrdId(): int
    {
        return $this->ordId;
    }

    /**
     * Set the value of ordId.
     */
    public function setOrdId(int $ordId): self
    {
        $this->ordId = $ordId;

        return $this;
    }

    /**
     * Get the value of ordNumber.
     */
    public function getOrdNumber(): string
    {
        return $this->ordNumber;
    }

    /**
     * Set the value of ordNumber.
     */
    public function setOrdNumber(string $ordNumber): self
    {
        $this->ordNumber = $ordNumber;

        return $this;
    }

    /**
     * Get the value of ordUserId.
     */
    public function getOrdUserId(): int
    {
        return $this->ordUserId;
    }

    /**
     * Set the value of ordUserId.
     */
    public function setOrdUserId(int $ordUserId): self
    {
        $this->ordUserId = $ordUserId;

        return $this;
    }

    /**
     * Get the value of ordPmtMode.
     */
    public function getOrdPmtMode(): string
    {
        return $this->ordPmtMode;
    }

    /**
     * Set the value of ordPmtMode.
     */
    public function setOrdPmtMode(string $ordPmtMode): self
    {
        $this->ordPmtMode = $ordPmtMode;

        return $this;
    }

    /**
     * Get the value of ordPayTransactionId.
     */
    public function getOrdPayTransactionId(): int
    {
        return $this->ordPayTransactionId;
    }

    /**
     * Set the value of ordPayTransactionId.
     */
    public function setOrdPayTransactionId(int $ordPayTransactionId): self
    {
        $this->ordPayTransactionId = $ordPayTransactionId;

        return $this;
    }

    /**
     * Get the value of ordDeliveryAddress.
     */
    public function getOrdDeliveryAddress(): int
    {
        return $this->ordDeliveryAddress;
    }

    /**
     * Set the value of ordDeliveryAddress.
     */
    public function setOrdDeliveryAddress(int $ordDeliveryAddress): self
    {
        $this->ordDeliveryAddress = $ordDeliveryAddress;

        return $this;
    }

    /**
     * Get the value of ordInvoiceAddress.
     */
    public function getOrdInvoiceAddress(): string
    {
        return $this->ordInvoiceAddress;
    }

    /**
     * Set the value of ordInvoiceAddress.
     */
    public function setOrdInvoiceAddress(string $ordInvoiceAddress): self
    {
        $this->ordInvoiceAddress = $ordInvoiceAddress;

        return $this;
    }

    /**
     * Get the value of ordAmountHt.
     */
    public function getOrdAmountHt(): string
    {
        return $this->ordAmountHt;
    }

    /**
     * Set the value of ordAmountHt.
     */
    public function setOrdAmountHt(string $ordAmountHt): self
    {
        $this->ordAmountHt = $ordAmountHt;

        return $this;
    }

    /**
     * Get the value of ordAmountTtc.
     */
    public function getOrdAmountTtc(): string
    {
        return $this->ordAmountTtc;
    }

    /**
     * Set the value of ordAmountTtc.
     */
    public function setOrdAmountTtc(string $ordAmountTtc): self
    {
        $this->ordAmountTtc = $ordAmountTtc;

        return $this;
    }

    /**
     * Get the value of ordTax.
     */
    public function getOrdTax(): string
    {
        return $this->ordTax;
    }

    /**
     * Set the value of ordTax.
     */
    public function setOrdTax(string $ordTax): self
    {
        $this->ordTax = $ordTax;

        return $this;
    }

    /**
     * Get the value of ordQty.
     */
    public function getOrdQty(): int
    {
        return $this->ordQty;
    }

    /**
     * Set the value of ordQty.
     */
    public function setOrdQty(int $ordQty): self
    {
        $this->ordQty = $ordQty;

        return $this;
    }

    /**
     * Get the value of ordDeliveryDate.
     */
    public function getOrdDeliveryDate(): DateTimeInterface
    {
        return $this->ordDeliveryDate;
    }

    /**
     * Set the value of ordDeliveryDate.
     */
    public function setOrdDeliveryDate(DateTimeInterface $ordDeliveryDate): self
    {
        $this->ordDeliveryDate = $ordDeliveryDate;

        return $this;
    }

    /**
     * Get the value of ordShippingClass.
     */
    public function getOrdShippingClass(): string
    {
        return $this->ordShippingClass;
    }

    /**
     * Set the value of ordShippingClass.
     */
    public function setOrdShippingClass(string $ordShippingClass): self
    {
        $this->ordShippingClass = $ordShippingClass;

        return $this;
    }

    /**
     * Get the value of ordStatus.
     */
    public function getOrdStatus(): int
    {
        return $this->ordStatus;
    }

    /**
     * Set the value of ordStatus.
     */
    public function setOrdStatus(int $ordStatus): self
    {
        $this->ordStatus = $ordStatus;

        return $this;
    }

    /**
     * Get the value of ordPmtStatus.
     */
    public function getOrdPmtStatus(): string
    {
        return $this->ordPmtStatus;
    }

    /**
     * Set the value of ordPmtStatus.
     */
    public function setOrdPmtStatus(string $ordPmtStatus): self
    {
        $this->ordPmtStatus = $ordPmtStatus;

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
     * Get the value of deleted.
     */
    public function getDeleted(): int
    {
        return $this->deleted;
    }

    /**
     * Set the value of deleted.
     */
    public function setDeleted(int $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }
}
