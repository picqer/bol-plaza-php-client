<?php

namespace Picqer\BolPlazaClient\Entities;

/**
 * Class BolPlazaOpenOrderItem
 * @package Picqer\BolPlazaClient\Entities
 *
 * @param string $OrderItemId
 * @param string $EAN
 * @param string $Title
 * @param string $Quantity
 * @param string $Price
 * @param string $DeliveryPeriod
 * @param string $TransactionFee
 */
class BolPlazaOpenOrderItem extends BaseModel {

    protected $xmlEntityName = 'OpenOrderItem';

    protected $attributes = [
        'OrderItemId',
        'EAN',
        'ReferenceCode',
        'Title',
        'Quantity',
        'Price',
        'DeliveryPeriod',
        'TransactionFee'
    ];

}