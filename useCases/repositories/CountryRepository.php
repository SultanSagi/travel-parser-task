<?php

namespace app\useCases\repositories;

use Yii;
use yii\db\Query;
use Exception;

class CountryRepository
{
    private $table = 'country';
    
    public function getAll(): array
    {
        $query = (new Query())
            ->select(['id', 'name', 'pki', 'sort'])
            ->from($this->table)
            ->all();

        return $query;
    }

    public function get(string $pki): array
    {
        if(!$country = (new Query)->from($this->table)->where(['pki' => $pki])->one()) {
            throw new Exception('Country is not found.');
        }
        return $country;
    }

    public function existsByPki(string $id): bool
    {
        return (new Query)->from($this->table)->where(['pki' => (int)$id])->exists();
    }

    public function update(int $pki, string $name, int $sort)
    {
        Yii::$app->db->createCommand("UPDATE country SET name=:name, sort=:sort WHERE pki=:pki")
            ->bindValue(':name', $name)
            ->bindValue(':sort', $sort)
            ->bindValue(':pki', $pki)
            ->execute();
    }

    public function create(int $pki, string $name, int $sort)
    {
        Yii::$app->db->createCommand()->insert($this->table, [
            'name' => $name,
            'pki' => $pki,
            'sort' => $sort,
        ])->execute();
    }
}
