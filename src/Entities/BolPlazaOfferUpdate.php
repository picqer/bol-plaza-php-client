<?php

namespace Picqer\BolPlazaClient\Entities;

/**
 * Class BolPlazaOfferUpdate
 * @package Picqer\BolPlazaClient\Entities
 *
 * @property string $Price
 * @property string $DeliveryCode
 * @property string $Publish
 * @property string $ReferenceCode
 * @property string $Description
 */
class BolPlazaOfferUpdate extends BaseModel {

    protected $xmlEntityName = 'OfferUpdate';

    protected $attributes = [
        'Price',
        'DeliveryCode',
        'Publish',
        'ReferenceCode',
        'Description'
    ];
}
