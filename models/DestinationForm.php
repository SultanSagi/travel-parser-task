<?php

namespace app\models;

use app\useCases\repositories\CityRepository;
use app\useCases\repositories\CountryRepository;
use app\useCases\repositories\DestinationRepository;
use yii\base\Model;

class DestinationForm extends Model
{
    public $price;
    public $cur;
    public $days;
    public $defaultDate;
    public $cityPki;
    public $countryPki;

    public function rules()
    {
        return [
            [['price', 'cur', 'cityPki', 'countryPki'], 'required'],
            [['price'], 'integer'],
            [['cur'], 'string'],
            ['cityPki', 'validateCity'],
            ['countryPki', 'validateCountry'],
            [['cityPki', 'countryPki'], 'validateDestination'],
        ];
    }

    public function validateCity()
    {
        $cities = new CityRepository;
        if (!$cities->existsByPki($this->cityPki)) {
            $this->addError('cityPki', 'Incorrect city pki');
        }
    }

    public function validateCountry()
    {
        $countries = new CountryRepository;
        if (!$countries->existsByPki($this->countryPki)) {
            $this->addError('countryPki', 'Incorrect country pki');
        }
    }

    public function validateDestination()
    {
        $cities = new CityRepository;
        $countries = new CountryRepository;
        $dest = new DestinationRepository;

        $city = $cities->get($this->cityPki);
        $country = $countries->get($this->countryPki);

        if ($dest->exists($country['id'], $city['id'])) {
            $this->addError('cityPki', 'This direction already exist');
        }
    }
}
