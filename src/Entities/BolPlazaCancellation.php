<?php

namespace Picqer\BolPlazaClient\Entities;

/**
 * Class BolPlazaCancellation
 * @package Picqer\BolPlazaClient\Entities
 *
 * @param string $DateTime
 * @param string $ReasonCode
 */
class BolPlazaCancellation extends BaseModel {

    protected $xmlEntityName = 'Cancellation';

    protected $attributes = [
        'DateTime',
        'ReasonCode'
    ];
}
