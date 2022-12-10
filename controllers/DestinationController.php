<?php

namespace app\controllers;

use yii\rest\Controller;
use app\useCases\services\DestinationService;

class DestinationController extends Controller
{
    private $service;

    public function __construct(
        $id,
        $module,
        DestinationService $service,
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
        $destinations = $this->service->getAll();
        return $this->serializeListItem($destinations);
    }

    private function serializeListItem($list): array
    {
        return array_map(function ($dest) {
            return [
                'price' => (int)$dest['price'],
                'cur' => $dest['cur'],
                'city_pki' => $dest['city_pki'],
                'country_pki' => $dest['country_pki'],
                'days' => unserialize($dest['days']),
                'defaultDate' => unserialize($dest['defaultDate']),
            ];
        }, $list);
    }
}
