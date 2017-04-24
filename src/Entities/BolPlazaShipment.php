<?php

namespace Picqer\BolPlazaClient\Entities;

/**
 * Class BolPlazaShipment
 * @package Picqer\BolPlazaClient\Entities
 *
 * @property string $OrderId
 * @property string $DateTimeCustomer
 * @property string $DateTimeDropShipper
 * @property BolPlazaBuyer $Buyer
 * @property array $OrderItems
 */
class BolPlazaShipment extends BaseModel {

    protected $xmlEntityName = 'Shipment';

    protected $attributes = [
        'ShipmentId',
        'ShipmentDate',
        'DateTimeDropShipper'
    ];

    protected $nestedEntities = [
        'CustomerDetails' => 'BolPlazaShipmentDetails',
        'Transport' => 'BolPlazaShipmentTransport'
    ];

    protected $childEntities = [
        'ShipmentItems' => [
            'childName' => 'ShipmentItem',
            'entityClass' => 'BolPlazaShipmentItem'
        ]
    ];
}
