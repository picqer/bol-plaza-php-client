<?php

namespace Picqer\BolPlazaClient\Entities;

/**
 * Class BolPlazaOpenOrder
 * @package Picqer\BolPlazaClient\Entities
 *
 * @property string $OrderId
 * @property string $DateTime
 * @property string $OrderItems
 * @property BolPlazaTransporter $Transporter
 */
class BolPlazaShipment extends BaseModel {

    protected $xmlEntityName = 'Shipment';

    protected $attributes = [
        'OrderId',
        'DateTime',
        'OrderItems',
    ];

    protected $nestedEntities = [
        'Transporter' => 'BolPlazaTransporter'
    ];

    protected $specialAttributes = [
        'OrderItems' => [
            'type' => 'array',
            'childName' => 'Id'
        ]
    ];
}