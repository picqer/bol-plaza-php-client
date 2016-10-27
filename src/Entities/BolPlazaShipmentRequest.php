<?php

namespace Wienkit\BolPlazaClient\Entities;

/**
 * Class BolPlazaShipmentRequest
 * @package Wienkit\BolPlazaClient\Entities
 *
 * @property string $OrderItemId
 * @property string ShipmentReference
 * @property string DateTime
 * @property string ExpectedDeliveryDate
 * @property BolPlazaTransport $Transport
 */
class BolPlazaShipmentRequest extends BaseModel {

    protected $xmlEntityName = 'ShipmentRequest';

    protected $attributes = [
        'OrderItemId',
        'ShipmentReference',
        'DateTime',
        'ExpectedDeliveryDate'
    ];

    protected $nestedEntities = [
        'Transport' => 'BolPlazaTransport'
    ];
}
