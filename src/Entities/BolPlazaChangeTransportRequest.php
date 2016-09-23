<?php

namespace Wienkit\BolPlazaClient\Entities;

/**
 * Class BolPlazaChangeTransportRequest
 * @package Wienkit\BolPlazaClient\Entities
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
