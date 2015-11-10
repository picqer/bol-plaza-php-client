<?php

namespace Picqer\BolPlazaClient\Entities;

/**
 * Class BolPlazaOpenOrder
 * @package Picqer\BolPlazaClient\Entities
 *
 * @property string $OrderId
 * @property string $DateTimeCustomer
 * @property string $DateTimeDropShipper
 * @property string $Paid
 * @property BolPlazaBuyer $Buyer
 * @property array $OpenOrderItems
 */
class BolPlazaOpenOrder extends BaseModel {

    protected $attributes = [
        'OrderId',
        'DateTimeCustomer',
        'DateTimeDropShipper',
        'Paid',
    ];

    protected $nestedEntities = [
        'Buyer' => 'BolPlazaBuyer'
    ];

    protected $childEntities = [
        'OpenOrderItems' => [
            'childName' => 'OpenOrderItem',
            'entityClass' => 'BolPlazaOpenOrderItem'
        ]
    ];

    public $test;
}