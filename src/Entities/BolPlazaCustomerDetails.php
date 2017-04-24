<?php

namespace Picqer\BolPlazaClient\Entities;

/**
 * Class BolPlazaCustomerDetails
 * @package Picqer\BolPlazaClient\Entities
 *
 * @param BolPlazaShipmentDetails $ShipmentDetails
 * @param BolPlazaBillingDetails $BillingDetails
 */
class BolPlazaCustomerDetails extends BaseModel {

    protected $xmlEntityName = 'CustomerDetails';

    protected $attributes = [];

    protected $nestedEntities = [
        'ShipmentDetails' => 'BolPlazaShipmentDetails',
        'BillingDetails' => 'BolPlazaBillingDetails',
    ];

}
