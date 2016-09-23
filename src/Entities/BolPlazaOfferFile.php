<?php

namespace Wienkit\BolPlazaClient\Entities;

/**
 * Class BolPlazaOfferFile
 * @package Wienkit\BolPlazaClient\Entities
 *
 * @property string $Url
 */
class BolPlazaOfferFile extends BaseModel {

    protected $xmlEntityName = 'OfferFile';

    protected $attributes = [
        'Url'
    ];
}
