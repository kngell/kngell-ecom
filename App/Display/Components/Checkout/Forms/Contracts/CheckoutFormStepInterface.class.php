<?php

declare(strict_types=1);

interface CheckoutFormStepInterface
{
    public function display() : string;
}