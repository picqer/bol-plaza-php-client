<?php

namespace Wienkit\BolPlazaClient\Entities;

/**
 * Class BolPlazaOfferCreate
 * @package Wienkit\BolPlazaClient\Entities
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
