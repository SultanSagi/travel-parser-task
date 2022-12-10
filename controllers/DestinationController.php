<?php

namespace app\controllers;

use yii\rest\Controller;
use api\providers\MapDataProvider;
use app\useCases\services\CountryService;
use yii\db\Query;

class DestinationController extends Controller
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
        $destinations = (new Query())
            ->select(['city.pki AS city_pki', 'country.pki AS country_pki', 'price', 'cur', 'days', 'defaultDate'])
            ->from('destination')
            ->join('LEFT JOIN', 'city', 'city.id = destination.city_id')
            ->join('LEFT JOIN', 'country', 'country.id = destination.country_id')
            ->indexBy('city_pki')
            ->limit(5)
            ->all();
        // return new ActiveDataProvider([
        //     'query' => $countries,
        // ]);
        return $destinations;
        echo '<pre>';
        die(var_dump($destinations));
    }
}
