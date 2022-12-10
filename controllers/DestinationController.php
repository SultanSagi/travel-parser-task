<?php

namespace app\controllers;

use Yii;
use app\models\DestinationForm;
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

    public function verbs(): array
    {
        return [
            'index' => ['GET'],
            'store' => ['POST'],
        ];
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

    public function actionStore()
    {
        $form = new DestinationForm();

        $form->load(Yii::$app->request->getBodyParams(), '');

        // echo '<pre>';
        // die(var_dump($form));
        
        if ($form->validate()) {
            $this->service->create($form);
        } else {
            return [
                'message' => array_values($form->errors)[0],
                'code' => 422,
            ];
        }
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
