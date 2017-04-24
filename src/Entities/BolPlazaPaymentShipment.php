<?php

namespace Picqer\BolPlazaClient\Entities;

/**
 * Class BolPlazaPaymentShipment
 * @package Picqer\BolPlazaClient\Entities
 *
 * @property string $ShipmentId
 * @property string $OrderId
 * @property string $PaymentShipmentAmount
 * @property string $PaymentShipmentVAT
 * @property string $PaymentStatus
 * @property string $ShipmentDate
 * @property array $PaymentShipmentItems
 */
class BolPlazaPaymentShipment extends BaseModel {

    protected $xmlEntityName = 'PaymentShipment';

    protected $attributes = [
        'ShipmentId',
        'OrderId',
        'PaymentShipmentAmount',
        'PaymentShipmentVAT',
        'PaymentStatus',
        'ShipmentDate'
    ];

    protected $childEntities = [
        'PaymentShipmentItems' => [
            'childName' => 'PaymentShipmentItem',
            'entityClass' => 'BolPlazaPaymentShipmentItem'
        ]
    ];
}
