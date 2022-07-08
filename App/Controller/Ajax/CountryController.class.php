<?php

declare(strict_types=1);

class CountryController extends Controller
{
    public function getCountries(array $args = [])
    {
        $model = $this->model(CountriesManager::class)->assign($this->isValidRequest());
        if ($this->request->exists('post')) {
            $data = $this->request->get();
            if ($data['csrftoken'] && $this->token->validateToken($data['csrftoken'], $data['frm_name'])) {
                $search = isset($data['searchTerm']) ? strtolower($data['searchTerm']) : '';
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
    }
}