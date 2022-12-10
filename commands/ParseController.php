<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use app\useCases\services\CityService;
use app\useCases\services\CountryService;
use yii\db\Query;

/**
 * This command imports the url: poedem.kz.
 *
 * This command is imports data from the poedem.kz.
 *
 */
class ParseController extends Controller
{
    private $cityService;
    private $countryService;

    public function __construct($id, $module, CityService $cityService, CountryService $countryService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->cityService = $cityService;
        $this->countryService = $countryService;
    }

    /**
     * This command save the data to db from poedem.kz endpoint.
     * @return void
     */
    public function actionIndex()
    {
        $url = Yii::$app->params['parsingUrl'];
        $data = file_get_contents($url);
        $data = json_decode($data, true);

        $this->cityService->import($data['cities']);
        foreach ($data['countries'] as $pki => $country) {
            if ((new Query())->from('country')->where(['pki' => (int)$pki])->exists()) {
                Yii::$app->db->createCommand("UPDATE country SET name=:name, sort=:sort WHERE pki=:pki")
                    ->bindValue(':name', $country['name'])
                    ->bindValue(':sort', $country['sort'])
                    ->bindValue(':pki', $pki)
                    ->execute();
            } else {
                Yii::$app->db->createCommand()->insert('country', [
                    'name' => $country['name'],
                    'pki' => $pki,
                    'sort' => $country['sort'],
                ])->execute();
            }
        }
        foreach ($data['directions'] as $cityPki => $countries) {
            foreach ($countries as $countryPki => $destination) {

                $city = (new Query)->from('city')->where(['pki' => $cityPki])->one();
                $country = (new Query)->from('country')->where(['pki' => $countryPki])->one();
                // echo '<pre>';
                // die(var_dump(serialize($destination['days'])));
                if (!$city || !$country) {
                    return false;
                }

                if ((new Query())->from('destination')->where(['country_id' => (int)$country['id'], 'city_id' => (int)$city['id']])->exists()) {
                    Yii::$app->db->createCommand("UPDATE destination SET price=:price, cur=:cur,defaultDate=:defaultDate, days=:days WHERE country_id=:country_id AND city_id=:city_id")
                        ->bindValue(':price', $destination['price'])
                        ->bindValue(':cur', $destination['cur'])
                        ->bindValue(':days', serialize($destination['days']))
                        ->bindValue(':defaultDate', serialize($destination['defaultDate']))
                        ->bindValue(':country_id', $country['id'])
                        ->bindValue(':defaultDate', $city['id'])
                        ->execute();
                } else {
                    Yii::$app->db->createCommand()->insert('destination', [
                        'country_id' => $country['id'],
                        'city_id' => $city['id'],
                        'price' => $destination['price'],
                        'cur' => $destination['cur'],
                        'days' => serialize($destination['days']),
                        'defaultDate' => serialize($destination['defaultDate']),
                    ])->execute();
                }
            }
        }
    }
}
