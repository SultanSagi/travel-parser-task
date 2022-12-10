<?php

namespace app\useCases\services;

use app\useCases\repositories\DestinationsRepository;

class DestinationService
{
    private $destinations;

    public function __construct(DestinationsRepository $destinations)
    {
        $this->destinations = $destinations;
    }
}
