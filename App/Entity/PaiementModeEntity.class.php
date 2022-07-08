<?php

declare(strict_types=1);

class PaiementModeEntity extends Entity
{
    /** @id */
    private int $pmId;
    private string $pmName;
    private string $pmDescr;
    private string $status;
    private int $deleted;
    private DateTimeInterface $createdAt;
    private DateTimeInterface $updatedAt;

    public function __construct()
    {
        $this->createdAt = !isset($this->createdAt) ? new DateTimeImmutable() : $this->createdAt;
    }

    /**
     * Get the value of pmId.
     */
    public function getPmId() : int
    {
        return $this->pmId;
    }

    /**
     * Set the value of pmId.
     *
     * @return  self
     */
    public function setPmId(int $pmId) : self
    {
        $this->pmId = $pmId;
        return $this;
    }

    /**
     * Get the value of pmName.
     */
    public function getPmName() : string
    {
        return $this->pmName;
    }

    /**
     * Set the value of pmName.
     *
     * @return  self
     */
    public function setPmName(string $pmName) : self
    {
        $this->pmName = $pmName;
        return $this;
    }

    /**
     * Get the value of pmDescr.
     */
    public function getPmDescr() : string
    {
        return $this->pmDescr;
    }

    /**
     * Set the value of pmDescr.
     *
     * @return  self
     */
    public function setPmDescr(string $pmDescr) : self
    {
        $this->pmDescr = $pmDescr;
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
     * Get the value of deleted.
     */
    public function getDeleted() : int
    {
        return $this->deleted;
    }

    /**
     * Set the value of deleted.
     *
     * @return  self
     */
    public function setDeleted(int $deleted) : self
    {
        $this->deleted = $deleted;
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