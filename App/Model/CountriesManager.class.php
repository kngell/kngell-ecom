<?php

declare(strict_types=1);

use League\ISO3166\ISO3166;

class CountriesManager extends Model
{
    protected string $_colID = 'id';
    protected string $_table = 'countries';
    protected bool $_flatDb = true;
    protected string $_language = 'fr';

    public function __construct()
    {
        parent::__construct($this->_table, $this->_colID, $this->_flatDb);
    }

    public function getAllCountries()
    {
        $countries = (new ISO3166)->all();
        $search = strtolower($this->entity->{$this->entity->getGetters('search_term')}());
        if ($search != 'undefined') {
            $countries = array_filter($countries, function ($countrie) use ($search) {
                return str_starts_with(strtolower($countrie['name']), $search);
            });
        }

        return array_map(function ($country) {
            return ['id' => $country['numeric'], 'text' => $this->response->htmlDecode($country['name'])];
        }, $countries);
    }

    public function country($id) : array
    {
        if (is_string($id)) {
            $country = (new ISO3166)->numeric($id);

            return [
                'id' => $country['numeric'],
                'name' => $country['name'],
            ];
        }
    }
}
