<?php

namespace Picqer\BolPlazaClient\Entities;

/**
 * Class BolPlazaShipmentRequest
 * @package Picqer\BolPlazaClient\Entities
 *
 * @property string $OrderItemId
 * @property string ShipmentReference
 * @property BolPlazaTransport $Transport
 */
class BolPlazaShipmentRequest extends BaseModel {

    protected $xmlEntityName = 'ShipmentRequest';

    protected $attributes = [
        'OrderItemId',
        'ShipmentReference',
    ];

    protected $nestedEntities = [
        'Transport' => 'BolPlazaTransport'
    ];
}
