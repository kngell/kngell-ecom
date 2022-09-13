<?php

declare(strict_types=1);

namespace App\Services;

use ContainerComponents;

#[ContainerComponents(name: 'second')]
class SecondService
{
    public function __construct(array $akono)
    {
    }
}