<?php

namespace Wienkit\BolPlazaClient\Entities;

/**
 * Class BolPlazaCancellation
 * @package Wienkit\BolPlazaClient\Entities
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
