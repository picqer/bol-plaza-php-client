<?php

namespace Picqer\BolPlazaClient\Entities;

/**
 * Class BolPlazaShipmentTransport
 * @package Picqer\BolPlazaClient\Entities
 *
 * @property string $TransportId
 * @property string $TransporterCode
 */
class BolPlazaShipmentTransport extends BaseModel {

    protected $xmlEntityName = 'Transport';

    protected $attributes = [
        'TransportId',
        'TransporterCode'
    ];
}
