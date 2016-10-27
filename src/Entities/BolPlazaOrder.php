<?php

namespace Picqer\BolPlazaClient\Entities;

/**
 * Class BolPlazaOrder
 * @package Picqer\BolPlazaClient\Entities
 *
 * @property string $OrderId
 * @property string $DateTimeCustomer
 * @property string $DateTimeDropShipper
 * @property BolPlazaBuyer $Buyer
 * @property array $OrderItems
 */
class BolPlazaOrder extends BaseModel {

    protected $xmlEntityName = 'Order';

    protected $attributes = [
        'OrderId',
        'DateTimeCustomer',
        'DateTimeDropShipper'
    ];

    protected $nestedEntities = [
        'CustomerDetails' => 'BolPlazaCustomerDetails'
    ];

    protected $childEntities = [
        'OrderItems' => [
            'childName' => 'OrderItem',
            'entityClass' => 'BolPlazaOrderItem'
        ]
    ];
}
