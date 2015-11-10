<?php

namespace Picqer\BolPlazaClient\Entities;

/**
 * Class BolPlazaBuyer
 * @package Picqer\BolPlazaClient\Entities
 *
 * @param BolPlazaShipmentDetails $ShipmentDetails
 * @param BolPlazaBillingDetails $BillingDetails
 */
class BolPlazaBuyer extends BaseModel {

    protected $xmlEntityName = 'Buyer';

    protected $attributes = [];

    protected $nestedEntities = [
        'ShipmentDetails' => 'BolPlazaShipmentDetails',
        'BillingDetails' => 'BolPlazaBillingDetails',
    ];

}