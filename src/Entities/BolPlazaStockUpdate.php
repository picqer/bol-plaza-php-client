<?php

namespace Picqer\BolPlazaClient\Entities;

/**
 * Class BolPlazaStockUpdate
 * @package Picqer\BolPlazaClient\Entities
 *
 * @property string $QuantityInStock
 */
class BolPlazaStockUpdate extends BaseModel {

    protected $xmlEntityName = 'StockUpdate';

    protected $attributes = [
        'QuantityInStock'
    ];
}
