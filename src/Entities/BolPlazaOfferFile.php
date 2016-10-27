<?php

namespace Picqer\BolPlazaClient\Entities;

/**
 * Class BolPlazaOfferFile
 * @package Picqer\BolPlazaClient\Entities
 *
 * @property string $Url
 */
class BolPlazaOfferFile extends BaseModel {

    protected $xmlEntityName = 'OfferFile';

    protected $attributes = [
        'Url'
    ];
}
