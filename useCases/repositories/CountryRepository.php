<?php

namespace app\useCases\repositories;

use Yii;
use yii\db\Query;

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

    public function existsByPki(string $id): bool
    {
        return (new Query)->from($this->table)->where(['pki' => (int)$id])->exists();
    }

    public function update(int $pki, string $name, int $sort)
    {
        Yii::$app->db->createCommand("UPDATE :table SET name=:name, sort=:sort WHERE pki=:pki")
            ->bindValue(':table', $this->table)
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
