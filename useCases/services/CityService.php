<?php

namespace app\useCases\services;

use app\useCases\repositories\CityRepository;

class CityService
{
    private $cities;

    public function __construct(CityRepository $cities)
    {
        $this->cities = $cities;
    }

    public function getAll(): array
    {
        return $this->cities->getAll();
    }

    public function import(array $cities): void
    {
        foreach ($cities as $pki => $city) {
            if ($this->cities->existsByPki($pki)) {
                $this->cities->update($pki, $city['name'], $city['sort']);
            } else {
                $this->cities->create($pki, $city['name'], $city['sort']);
            }
        }
    }
}
