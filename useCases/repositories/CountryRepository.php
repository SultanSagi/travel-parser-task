<?php

namespace app\useCases\repositories;

use yii\db\Query;

class CountryRepository
{
    public function getAll(): array
    {
        $query = (new Query())
            ->select(['id', 'name'])
            ->from('country')
            ->all();

        // echo '<pre>';
        // die(var_dump($query));
        return $query;
    }
}
