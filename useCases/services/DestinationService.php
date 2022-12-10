<?php

namespace app\useCases\services;

use app\models\DestinationForm;
use app\useCases\repositories\CityRepository;
use app\useCases\repositories\CountryRepository;
use app\useCases\repositories\DestinationRepository;

class DestinationService
{
    private $cities;
    private $countries;
    private $destinations;

    public function __construct(DestinationRepository $destinations, CityRepository $cities, CountryRepository $countries)
    {
        $this->cities = $cities;
        $this->countries = $countries;
        $this->destinations = $destinations;
    }

    public function getAll(): array
    {
        return $this->destinations->getAll();
    }

    public function create(DestinationForm $dest) {
        $city = $this->cities->get($dest->cityPki);
        $country = $this->countries->get($dest->countryPki);
        $this->destinations->create($dest, $country['id'], $city['id']);
    }

    public function import(array $destinations): void
    {
        foreach ($destinations as $cityPki => $countries) {
            foreach ($countries as $countryPki => $dest) {

                $city = $this->cities->get($cityPki);
                $country = $this->countries->get($countryPki);

                if ($this->destinations->exists($country['id'], $city['id'])) {
                    $this->destinations->update($dest['price'], $dest['cur'], $dest['days'], $dest['defaultDate'], $country['id'], $city['id']);
                } else {
                    $form = new DestinationForm();
                    $form->price = $dest['price'];
                    $form->cur = $dest['cur'];
                    $form->days = $dest['days'];
                    $form->defaultDate = $dest['defaultDate'];
                    $this->destinations->create($form, $country['id'], $city['id']);
                }
            }
        }
    }
}
