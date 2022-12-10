<?php

namespace app\useCases\services;

use app\useCases\repositories\CountryRepository;

class CountryService
{
    private $countries;

    public function __construct(CountryRepository $countries)
    {
        $this->countries = $countries;
    }

    public function getAll(): array
    {
        return $this->countries->getAll();
    }
}
