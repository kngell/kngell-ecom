<?php

declare(strict_types=1);

class CountryController extends Controller
{
    public function getCountries(array $args = [])
    {
        $results = $this->model(CountriesManager::class)->assign($this->isValidRequest())->getAllCountries();
        $this->jsonResponse(['result' => 'success', 'msg' => $results]);
    }
}