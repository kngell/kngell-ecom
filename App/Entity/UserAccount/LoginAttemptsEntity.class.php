<?php

declare(strict_types=1);

class LoginAttemptsEntity extends Entity
{
    /** @id */
    private int $laId;
    /** @UserID */
    private int $userId;
    private string $timestamp;
    private string $ip;
    /** @var DateTimeInterface */
    private DateTimeInterface $createdAt;
    /** @var DateTimeInterface */
    private DateTimeInterface $updatedAt;

    public function __construct()
    {
        $this->createdAt = !isset($this->createdAt) ? new DateTimeImmutable() : $this->createdAt;
    }

    /**
     * Get the value of timestamp.
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set the value of timestamp.
     *
     * @return  self
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Get the value of ip.
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set the value of ip.
     *
     * @return  self
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    public function delete(?string $field = null) : self
    {
        unset($this->$field);

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
     * Get the value of laId.
     */
    public function getLaId() : int
    {
        return $this->laId;
    }

    /**
     * Set the value of laId.
     *
     * @return  self
     */
    public function setLaId(int $laId) : self
    {
        $this->laId = $laId;

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
}
