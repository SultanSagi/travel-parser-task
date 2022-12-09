<?php

namespace app\controllers;

use yii\rest\Controller;
use api\providers\MapDataProvider;
use yii\data\ActiveDataProvider;
// use yii\db\Query;

class CountryController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $countries = (new \yii\db\Query())
            ->select(['id', 'name'])
            ->from('country')
            ->all();
        // return new ActiveDataProvider([
        //     'query' => $countries,
        // ]);
        // echo '<pre>';
        // die(var_dump($countries));
        return $countries;

        $dataProvider = $countries;
        return new MapDataProvider($dataProvider, [$this, 'serializeListItem']);
    }
}
