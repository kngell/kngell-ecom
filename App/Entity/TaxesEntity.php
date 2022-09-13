<?php

declare(strict_types=1);

class TaxesEntity extends Entity
{
    /** @id */
    private int $tId;
    private string $tName;
    private string $tDescr;
    private string $tRate;
    private string $tClass;
    private string $status;
    private DateTimeInterface $createdAt;
    private DateTimeInterface $updatedAt;

    public function __construct()
    {
        $this->createdAt = !isset($this->createdAt) ? new DateTimeImmutable() : $this->createdAt;
    }

    /**
     * Get the value of tId.
     */
    public function getTId() : int
    {
        return $this->tId;
    }

    /**
     * Set the value of tId.
     *
     * @return  self
     */
    public function setTId(int $tId)
    {
        $this->tId = $tId;

        return $this;
    }

    /**
     * Get the value of tName.
     */
    public function getTName() : string
    {
        return $this->tName;
    }

    /**
     * Set the value of tName.
     *
     * @return  self
     */
    public function setTName(string $tName) : self
    {
        $this->tName = $tName;

        return $this;
    }

    /**
     * Get the value of tDescr.
     */
    public function getTDescr() : string
    {
        return $this->tDescr;
    }

    /**
     * Set the value of tDescr.
     *
     * @return  self
     */
    public function setTDescr(string $tDescr) : self
    {
        $this->tDescr = $tDescr;

        return $this;
    }

    /**
     * Get the value of tRate.
     */
    public function getTRate() : string
    {
        return $this->tRate;
    }

    /**
     * Set the value of tRate.
     *
     * @return  self
     */
    public function setTRate(string $tRate) : self
    {
        $this->tRate = $tRate;

        return $this;
    }

    /**
     * Get the value of tClass.
     */
    public function getTClass() : string
    {
        return $this->tClass;
    }

    /**
     * Set the value of tClass.
     *
     * @return  self
     */
    public function setTClass(string $tClass) : self
    {
        $this->tClass = $tClass;

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
}
