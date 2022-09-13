<?php

declare(strict_types=1);

class AddressBookEntity extends Entity
{
    /** @id */
    private int $abId;
    private string $tbl;
    private int $relId;
    private string $address1;
    private string $address2;
    private string $zipCode;
    private string $ville;
    private string $region;
    private string $pays;
    private string $principale;
    private string $saveForLater;
    private string $billingAddr;
    private DateTimeInterface $createdAt;
    private DateTimeInterface $updatedAt;

    public function __construct()
    {
        $this->createdAt = !isset($this->createdAt) ? new DateTimeImmutable() : $this->createdAt;
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
     * Get the value of abId.
     */
    public function getAbId() : int
    {
        return $this->abId;
    }

    /**
     * Set the value of abId.
     *
     * @return  self
     */
    public function setAbId(int $abId) : self
    {
        $this->abId = $abId;

        return $this;
    }

    /**
     * Get the value of tbl.
     */
    public function getTbl() : string
    {
        return $this->tbl;
    }

    /**
     * Set the value of tbl.
     *
     * @return  self
     */
    public function setTbl(string $tbl) : self
    {
        $this->tbl = $tbl;

        return $this;
    }

    /**
     * Get the value of relId.
     */
    public function getRelId() : int
    {
        return $this->relId;
    }

    /**
     * Set the value of relId.
     *
     * @return  self
     */
    public function setRelId(int $relId) : self
    {
        $this->relId = $relId;

        return $this;
    }

    /**
     * Get the value of address1.
     */
    public function getAddress1() : string
    {
        return $this->htmlDecode($this->address1);
    }

    /**
     * Set the value of address1.
     *
     * @return  self
     */
    public function setAddress1(string $address1) : self
    {
        $this->address1 = $address1;

        return $this;
    }

    /**
     * Get the value of address2.
     */
    public function getAddress2() : string
    {
        return $this->htmlDecode($this->address2);
    }

    /**
     * Set the value of address2.
     *
     * @return  self
     */
    public function setAddress2(string $address2) : self
    {
        $this->address2 = $address2;

        return $this;
    }

    /**
     * Get the value of zipCode.
     */
    public function getZipCode() : string
    {
        return $this->zipCode;
    }

    /**
     * Set the value of zipCode.
     *
     * @return  self
     */
    public function setZipCode(string $zipCode) : self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Get the value of ville.
     */
    public function getVille() :  string
    {
        return $this->ville;
    }

    /**
     * Set the value of ville.
     *
     * @return  self
     */
    public function setVille(string $ville) : self
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get the value of region.
     */
    public function getRegion() : string
    {
        return $this->region;
    }

    /**
     * Set the value of region.
     *
     * @return  self
     */
    public function setRegion(string $region) : self
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get the value of pays.
     */
    public function getPays() :  string
    {
        return $this->pays;
    }

    /**
     * Set the value of pays.
     *
     * @return  self
     */
    public function setPays(string $pays) : self
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get the value of principale.
     */
    public function getPrincipale() : string
    {
        return $this->principale;
    }

    /**
     * Set the value of principale.
     *
     * @return  self
     */
    public function setPrincipale(string $principale) : self
    {
        $this->principale = $principale;

        return $this;
    }

    /**
     * Get the value of saveForLater.
     */
    public function getSaveForLater() : string
    {
        return $this->saveForLater;
    }

    /**
     * Set the value of saveForLater.
     *
     * @return  self
     */
    public function setSaveForLater(string $saveForLater) : self
    {
        $this->saveForLater = $saveForLater;

        return $this;
    }

    /**
     * Get the value of billingAddr.
     */
    public function getBillingAddr() : string
    {
        return $this->billingAddr;
    }

    /**
     * Set the value of billingAddr.
     *
     * @return  self
     */
    public function setBillingAddr(string $billingAddr) : self
    {
        $this->billingAddr = $billingAddr;

        return $this;
    }

    public function delete(?string $field = null) : self
    {
        unset($this->$field);

        return $this;
    }
}
