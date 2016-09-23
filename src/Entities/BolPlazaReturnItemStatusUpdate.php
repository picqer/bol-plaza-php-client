<?php

namespace Wienkit\BolPlazaClient\Entities;

/**
 * Class BolPlazaReturnItemStatusUpdate
 * @package Wienkit\BolPlazaClient\Entities
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
