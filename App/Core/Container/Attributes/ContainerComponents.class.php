<?php

declare(strict_types=1);

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class ContainerComponents
{
    public function __construct(public string $name = '')
    {
    }
}
