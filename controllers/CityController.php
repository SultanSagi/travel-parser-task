<?php

namespace app\controllers;

use yii\rest\Controller;
use app\useCases\services\CityService;

class CityController extends Controller
{
    private $service;

    public function __construct(
        $id,
        $module,
        CityService $service,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * Displays cities.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->service->getAll();
    }
}
