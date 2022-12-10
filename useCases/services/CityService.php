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

    public function import(array $cities)
    {
        foreach ($cities as $ski => $city) {
            if ($this->cities->existsByPki($ski)) {
                $this->cities->update($ski, $city['name'], $city['sort']);
            } else {
                $this->cities->create($ski, $city['name'], $city['sort']);
            }
        }
    }
}
