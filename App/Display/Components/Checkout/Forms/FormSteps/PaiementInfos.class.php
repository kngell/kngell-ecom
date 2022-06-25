<?php

declare(strict_types=1);

class PaiementInfos extends AbstractFormSteps
{
    public function __construct(private ?object $frm = null, private ?object $obj = null)
    {
    }

    public function paiementInfos() : string
    {
        return '';
    }
}