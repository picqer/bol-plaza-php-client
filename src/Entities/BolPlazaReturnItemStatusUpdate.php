<?php

namespace Picqer\BolPlazaClient\Entities;

/**
 * Class BolPlazaReturnItemStatusUpdate
 * @package Picqer\BolPlazaClient\Entities
 *
 * @param string $StatusReason
 * @param string $QuantityReturned
 */
class BolPlazaReturnItemStatusUpdate extends BaseModel {

    protected $xmlEntityName = 'ReturnItemStatusUpdate';

    protected $attributes = [
        'StatusReason',
        'QuantityReturned'
    ];
}
