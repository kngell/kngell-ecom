<?php

declare(strict_types=1);

class CountriesEntity extends Entity
{
    private string $searchTerm;

    /**
     * Get the value of searchTerm.
     */
    public function getSearchTerm(): string
    {
        return $this->searchTerm;
    }

    /**
     * Set the value of searchTerm.
     */
    public function setSearchTerm(string $searchTerm): self
    {
        $this->searchTerm = $searchTerm;

        return $this;
    }
}