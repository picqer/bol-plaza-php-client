<?php

namespace Picqer\BolPlazaClient\Entities;

/**
 * Class BolPlazaTransporter
 * @package Picqer\BolPlazaClient\Entities
 *
 * @property string $TransporterCode
 * @property string $TrackAndTrace
 */
class BolPlazaTransport extends BaseModel {

    protected $xmlEntityName = 'Transport';

    protected $attributes = [
        'TransporterCode',
        'TrackAndTrace',
    ];
}
