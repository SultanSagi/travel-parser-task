<?php

namespace app\controllers;

use yii\rest\Controller;
use app\useCases\services\CountryService;
use app\useCases\services\CityService;
use app\useCases\services\DestinationService;

class AllResultsController extends Controller
{
    private $countryService;
    private $cityService;
    private $destinationService;

    public function __construct(
        $id,
        $module,
        CountryService $countryService,
        CityService $cityService,
        DestinationService $destinationService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->countryService = $countryService;
        $this->cityService = $cityService;
        $this->destinationService = $destinationService;
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $results = [];

        $results['cities'] = $this->cityService->getAll();
        $results['countries'] = $this->countryService->getAll();
        $destinations = $this->destinationService->getAll();

        $results['destinations'] = $this->serializeListItem($destinations);

        return $results;;
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
