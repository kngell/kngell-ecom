<?php

declare(strict_types=1);

use Attribute;

#[Attribute(Attribute::TARGET_PARAMETER | Attribute::TARGET_PROPERTY)]
class Qualifier extends ContainerComponents
{
    public function __construct(public string $serviceName = '')
    {
    }
}
