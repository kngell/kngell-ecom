<?php

declare(strict_types=1);

class CountryController extends Controller
{
    public function getCountries(array $args = [])
    {
        $model = $this->model(CountriesManager::class)->assign($data = $this->isValidRequest());
        $search = isset($data['searchTerm']) && $data['searchTerm'] != 'undefined' ? strtolower($data['searchTerm']) : '';
        $conutries_json = file_get_contents(FILES . 'json' . DS . 'data' . DS . 'countries.json');
        $countries = array_filter(array_column(json_decode($conutries_json, true), 'name'), function ($countrie) use ($search) {
            return str_starts_with(strtolower($countrie), $search);
        });
        $results = array_map(function ($i, $map_countrie) {
            return ['id' => $i, 'text' => $map_countrie];
        }, array_keys($countries), $countries);
        $this->jsonResponse(['result' => 'success', 'msg' => $results]);
    }
}