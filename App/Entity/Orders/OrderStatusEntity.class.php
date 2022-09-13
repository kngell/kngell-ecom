<?php

declare(strict_types=1);

class OrderStatusEntity extends Entity
{
    /** @id */
    private int $osId;
    private string $status;
    private string $descr;
    private DateTimeInterface $createdAt;
    private DateTimeInterface $updatedAt;
    private int $deleted;

    public function __construct()
    {
        $this->createdAt = !isset($this->createdAt) ? new DateTimeImmutable() : $this->createdAt;
    }

    /**
     * Get the value of osId.
     */
    public function getOsId(): int
    {
        return $this->osId;
    }

    /**
     * Set the value of osId.
     */
    public function setOsId(int $osId): self
    {
        $this->osId = $osId;

        return $this;
    }

    /**
     * Get the value of status.
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Set the value of status.
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of descr.
     */
    public function getDescr(): string
    {
        return $this->descr;
    }

    /**
     * Set the value of descr.
     */
    public function setDescr(string $descr): self
    {
        $this->descr = $descr;

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
