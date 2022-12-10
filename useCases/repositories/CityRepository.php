<?php

namespace app\useCases\repositories;

use Yii;
use yii\db\Query;

class CityRepository
{
    public function getAll(): array
    {
        $query = (new Query())
            ->select(['id', 'name'])
            ->from('city')
            ->all();

        return $query;
    }

    public function existsByPki(string $id): bool
    {
        return (new Query)->from('city')->where(['pki' => (int)$id])->exists();
    }

    public function update(int $pki, string $name, int $sort)
    {
        Yii::$app->db->createCommand("UPDATE city SET name=:name, sort=:sort WHERE pki=:pki")
            ->bindValue(':name', $name)
            ->bindValue(':sort', $sort)
            ->bindValue(':pki', $pki)
            ->execute();
    }

    public function create(int $pki, string $name, int $sort)
    {
        Yii::$app->db->createCommand()->insert('city', [
            'name' => $name,
            'pki' => $pki,
            'sort' => $sort,
        ])->execute();
    }
}
