<?php

declare(strict_types=1);

namespace App\Services;

use Qualifier;
use Services;

#[Services()]
class ThirdService
{
    public function __construct(private FirstService $firstservice, #[Qualifier(serviceName: 'second')]private SecondService $secondService)
    {
    }
}