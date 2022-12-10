<?php

namespace app\useCases\repositories;

use Yii;
use yii\db\Query;

class DestinationRepository
{
    private $table = 'destination';

    public function exists(string $countryId, string $cityId): bool
    {
        return (new Query)->from($this->table)->where(['country_id' => (int)$countryId, 'city_id' => (int)$cityId])->exists();
    }
    // public function getAll(): array
    // {
    //     $query = (new Query())
    //         ->select(['id', 'name'])
    //         ->from('country')
    //         ->getAll();
    //     return $query;
    // }

    public function update(int $price, string $cur, array $days, array $defaultDate, string $countryId, string $cityId)
    {
        Yii::$app->db->createCommand("UPDATE destination SET price=:price, cur=:cur,defaultDate=:defaultDate, days=:days WHERE country_id=:country_id AND city_id=:city_id")
            ->bindValue(':price', $price)
            ->bindValue(':cur', $cur)
            ->bindValue(':days', serialize($days))
            ->bindValue(':defaultDate', serialize($defaultDate))
            ->bindValue(':country_id', $countryId)
            ->bindValue(':city_id', $cityId)
            ->execute();
    }

    public function create(int $price, string $cur, array $days, array $defaultDate, string $countryId, string $cityId)
    {
        Yii::$app->db->createCommand()->insert($this->table, [
            'country_id' => $countryId,
            'city_id' => $cityId,
            'price' => $price,
            'cur' => $cur,
            'days' => serialize($days),
            'defaultDate' => serialize($defaultDate),
        ])->execute();
    }
}
