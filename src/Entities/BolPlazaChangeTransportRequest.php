<?php

namespace Picqer\BolPlazaClient\Entities;

/**
 * Class BolPlazaChangeTransportRequest
 * @package Picqer\BolPlazaClient\Entities
 *
 * @param BolPlazaShipmentDetails $ShipmentDetails
 * @param BolPlazaBillingDetails $BillingDetails
 */
class BolPlazaChangeTransportRequest extends BaseModel {

    protected $xmlEntityName = 'ChangeTransportRequest';

    protected $attributes = [
        'TransporterCode',
        'TrackAndTrace'
    ];

}
