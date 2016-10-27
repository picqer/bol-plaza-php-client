<?php

namespace Wienkit\BolPlazaClient\Entities;

/**
 * Class BolPlazaShipmentItem
 * @package Wienkit\BolPlazaClient\Entities
 *
 * @param BolPlazaOrderItem $OrderItem
 */
class BolPlazaShipmentItem extends BaseModel {

    protected $xmlEntityName = 'ShipmentItem';

    protected $nestedEntities = [
        'OrderItem' => 'BolPlazaOrderItem'
    ];

}
