<?php

namespace app\useCases\services;

use app\useCases\repositories\CityRepository;

class ParserService
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
                // Yii::$app->db->createCommand("UPDATE city SET name=:name, sort=:sort WHERE pki=:pki")
                //     ->bindValue(':name', $city['name'])
                //     ->bindValue(':sort', $city['sort'])
                //     ->bindValue(':pki', $id)
                //     ->execute();
            } else {
                $this->cities->create($ski, $city['name'], $city['sort']);
                // Yii::$app->db->createCommand()->insert('city', [
                //     'name' => $city['name'],
                //     'pki' => $id,
                //     'sort' => $city['sort'],
                // ])->execute();
            }
        }
    }
}
