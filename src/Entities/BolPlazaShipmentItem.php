<?php

namespace Picqer\BolPlazaClient\Entities;

/**
 * Class BolPlazaShipmentItem
 * @package Picqer\BolPlazaClient\Entities
 *
 * @param BolPlazaOrderItem $OrderItem
 */
class BolPlazaShipmentItem extends BaseModel {

    protected $xmlEntityName = 'ShipmentItem';

    protected $nestedEntities = [
        'OrderItem' => 'BolPlazaOrderItem'
    ];

}
