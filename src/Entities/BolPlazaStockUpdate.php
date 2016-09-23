<?php

namespace Wienkit\BolPlazaClient\Entities;

/**
 * Class BolPlazaStockUpdate
 * @package Wienkit\BolPlazaClient\Entities
 *
 * @property string $QuantityInStock
 */
class BolPlazaStockUpdate extends BaseModel {

    protected $xmlEntityName = 'StockUpdate';

    protected $attributes = [
        'QuantityInStock'
    ];
}
