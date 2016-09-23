<?php

namespace Wienkit\BolPlazaClient\Entities;

/**
 * Class BolPlazaCustomerDetails
 * @package Wienkit\BolPlazaClient\Entities
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
