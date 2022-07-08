<?php

declare(strict_types=1);

class DisplaySearchBox
{
    public function __construct(private SearchBoxForm $searchBoxForm)
    {
    }

    public function searchBox() : array
    {
        return ['search_box' => $this->searchBoxForm->createForm('')];
    }
}