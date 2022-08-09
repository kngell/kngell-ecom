<?php

declare(strict_types=1);
class CountriesManager extends Model
{
    protected string $_colID = 'id';
    protected string $_table = 'countries';
    protected bool $_flatDb = true;
    protected string $_language = 'fr';
    protected string $coutriesPath = VENDOR . 'stefangabos' . DS . 'world_countries' . DS . 'data' . DS . 'countries';

    public function __construct()
    {
        parent::__construct($this->_table, $this->_colID, $this->_flatDb);
    }

    public function getAllCountries()
    {
        $path = $this->coutriesPath . DS . $this->_language . DS . 'countries.php';
        $countries = [];
        if (file_exists($path)) {
            $countries = require $path;
        }
        return new Collection($countries);
    }
}