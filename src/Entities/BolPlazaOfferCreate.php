<?php

namespace Picqer\BolPlazaClient\Entities;

/**
 * Class BolPlazaOfferCreate
 * @package Picqer\BolPlazaClient\Entities
 *
 * @property string $EAN
 * @property string $Condition
 * @property string $Price
 * @property string $DeliveryCode
 * @property string $QuantityInStock
 * @property string $Publish
 * @property string $ReferenceCode
 * @property string $Description
 */
class BolPlazaOfferCreate extends BaseModel {

    protected $xmlEntityName = 'OfferCreate';

    protected $attributes = [
        'EAN',
        'Condition',
        'Price',
        'DeliveryCode',
        'QuantityInStock',
        'Publish',
        'ReferenceCode',
        'Description'
    ];
}
