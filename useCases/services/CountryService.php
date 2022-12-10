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

    public function import(array $countries): void
    {
        foreach ($countries as $pki => $country) {
            if ($this->countries->existsByPki($pki)) {
                $this->countries->update($pki, $country['name'], $country['sort']);
            } else {
                $this->countries->create($pki, $country['name'], $country['sort']);
            }
        }
    }
}
