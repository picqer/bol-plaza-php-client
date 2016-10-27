<?php

namespace Wienkit\BolPlazaClient\Entities;

/**
 * Class BolPlazaShipmentTransport
 * @package Wienkit\BolPlazaClient\Entities
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
