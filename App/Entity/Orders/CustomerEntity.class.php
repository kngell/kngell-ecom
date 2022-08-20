<?php

declare(strict_types=1);

class CustomerEntity extends Entity
{
    /** @id */
    private int $userId;
    private string $orderId;
    private string $lastName;
    private string $firstName;
    private string $userName;
    private string $email;
    private string $shipTo;
    private string $billTo;
    private array $shippingMethod;
    private string $promo;
    private CollectionInterface $cartSummary;
    /** @media */
    private string $profileImage;
    private string $phone;
    private CollectionInterface $address;
    /** @var DateTimeInterface */
    private DateTimeInterface $registerDate;

    public function __construct()
    {
        if (!isset($this->registerDate)) {
            $this->registerDate = new DateTimeImmutable();
        }
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
     * Get the value of lastName.
     */
    public function getLastName() : string
    {
        return $this->lastName;
    }

    /**
     * Set the value of lastName.
     *
     * @return  self
     */
    public function setLastName(string $lastName) : self
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * Get the value of firstName.
     */
    public function getFirstName() : string
    {
        return $this->firstName;
    }

    /**
     * Set the value of firstName.
     *
     * @return  self
     */
    public function setFirstName(string $firstName) : self
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * Get the value of userName.
     */
    public function getUserName() : string
    {
        return $this->userName;
    }

    /**
     * Set the value of userName.
     *
     * @return  self
     */
    public function setUserName(string $userName) : self
    {
        $this->userName = $userName;
        return $this;
    }

    /**
     * Get the value of email.
     */
    public function getEmail() : string
    {
        return $this->email;
    }

    /**
     * Set the value of email.
     *
     * @return  self
     */
    public function setEmail(string $email) : self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get the value of registerDate.
     */
    public function getRegisterDate() : DateTimeInterface
    {
        return $this->registerDate;
    }

    /**
     * Set the value of registerDate.
     *
     * @return  self
     */
    public function setRegisterDate(DateTimeInterface $registerDate) : self
    {
        $this->registerDate = $registerDate;
        return $this;
    }

    /**
     * Get the value of profileImage.
     */
    public function getProfileImage() : string
    {
        return $this->profileImage;
    }

    /**
     * Set the value of profileImage.
     *
     * @return  self
     */
    public function setProfileImage(string $profileImage) : self
    {
        $this->profileImage = $profileImage;
        return $this;
    }

    /**
     * Get the value of phone.
     */
    public function getPhone() : string
    {
        return $this->phone;
    }

    /**
     * Set the value of phone.
     *
     * @return  self
     */
    public function setPhone(string $phone) : self
    {
        $this->phone = $phone;
        return $this;
    }

    public function updateAddress(object $newAddress) : self
    {
        if ($this->address->count() > 0) {
            /** @var CollectionInterface */
            $add = new Collection([]);
            foreach ($this->address->all() as $address) {
                property_exists($newAddress, 'principale') && $newAddress->principale === 1 && $newAddress != $address ? $address->principale = 0 : '';
                property_exists($newAddress, 'billing_addr') && $newAddress->billing_addr == 'on' && $newAddress != $address ? $address->billing_addr = '' : '';
                if ($address->ab_id === $newAddress->ab_id) {
                    $add->add($newAddress);
                } else {
                    $add->add($address);
                }
            }
            $this->address = $add;
        }
        return $this;
    }

    /**
     * Get the value of address.
     */
    public function getAddress() : CollectionInterface
    {
        return $this->address;
    }

    /**
     * Set the value of address.
     *
     * @return  self
     */
    public function setAddress(CollectionInterface $address) : self
    {
        $this->address = $address;
        return $this;
    }

    public function delete(?string $field = null): Entity
    {
        if ($field == 'address') {
            $this->address->removeByValue($field);
        } else {
            unset($this->field);
        }
        return $this;
    }

    /**
     * Get the value of shipTo.
     */
    public function getShipTo() : string
    {
        return $this->shipTo;
    }

    /**
     * Set the value of shipTo.
     *
     * @return  self
     */
    public function setShipTo(string $shipTo) : self
    {
        $this->shipTo = $shipTo;
        return $this;
    }

    /**
     * Get the value of billTo.
     */
    public function getBillTo() : string
    {
        return $this->billTo;
    }

    /**
     * Set the value of billTo.
     *
     * @return  self
     */
    public function setBillTo(string $billTo) : self
    {
        $this->billTo = $billTo;
        return $this;
    }

    /**
     * Get the value of shippingMethod.
     */
    public function getShippingMethod() : array
    {
        return $this->shippingMethod;
    }

    /**
     * Set the value of shippingMethod.
     *
     * @return  self
     */
    public function setShippingMethod(array $shippingMethod) : self
    {
        $this->shippingMethod = $shippingMethod;
        return $this;
    }

    /**
     * Get the value of promo.
     */
    public function getPromo() : string
    {
        return $this->promo;
    }

    /**
     * Set the value of promo.
     *
     * @return  self
     */
    public function setPromo(string $promo) : self
    {
        $this->promo = $promo;
        return $this;
    }

    /**
     * Get the value of cartSummary.
     */
    public function getCartSummary() : CollectionInterface
    {
        return $this->cartSummary;
    }

    /**
     * Set the value of cartSummary.
     *
     * @return  self
     */
    public function setCartSummary(CollectionInterface $cartSummary) : self
    {
        $this->cartSummary = $cartSummary;
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
}