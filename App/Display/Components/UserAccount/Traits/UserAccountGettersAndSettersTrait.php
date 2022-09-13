<?php

declare(strict_types=1);

trait UserAccountGettersAndSettersTrait
{
    public function setCustomer(?CustomerEntity $customerEntity): self
    {
        $this->customerEntity = $customerEntity;

        return $this;
    }

    protected function cardIcon(object $card) : string
    {
        return match ($card->brand) {
            'Visa' => '<i class="fa-brands fa-cc-visa"></i>',
        };
    }
}
