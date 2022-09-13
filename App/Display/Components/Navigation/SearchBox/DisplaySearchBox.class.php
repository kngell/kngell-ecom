<?php

declare(strict_types=1);

class DisplaySearchBox implements DisplayPagesInterface
{
    public function __construct(private SearchBoxForm $searchBoxForm)
    {
    }

    public function displayAll(): array
    {
        return ['search_box' => $this->searchBoxForm->createForm('')];
    }
}
