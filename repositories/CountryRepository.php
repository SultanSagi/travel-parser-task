<?php

namespace app\repositories;

use yii\db\Query;

class CountryRepository
{
    public function getAll(): array
    {
        $query = (new Query())
        ->select(['id', 'name'])
        ->from('country')
        ->getAll();
        return $query;
    }
}
