<?php

namespace app\controllers;

use yii\rest\Controller;
use api\providers\MapDataProvider;
use app\useCases\services\CountryService;
use yii\data\ActiveDataProvider;
use yii\debug\models\timeline\DataProvider;

class CountryController extends Controller
{
    private $service;

    public function __construct(
        $id,
        $module,
        CountryService $service,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        // $countries = (new \yii\db\Query())
        //     ->select(['id', 'name'])
        //     ->from('country')
        //     ->all();
        // return new ActiveDataProvider([
        //     'query' => $countries,
        // ]);
        // echo '<pre>';
        // die(var_dump($countries));
        return $this->service->getAll();

        // $dataProvider = $this->service->getAll();
        // return new DataProvider($dataProvider);
    }
}
