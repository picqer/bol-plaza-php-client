<?php

namespace Picqer\BolPlazaClient\Entities;

/**
 * Class BolPlazaTransporter
 * @package Picqer\BolPlazaClient\Entities
 *
 * @property string $Code
 * @property string $TrackAndTraceCode
 */
class BolPlazaTransporter extends BaseModel {

    protected $xmlEntityName = 'Transporter';

    protected $attributes = [
        'Code',
        'TrackAndTraceCode',
    ];

}