<?php

namespace Wienkit\BolPlazaClient\Entities;

/**
 * Class BolPlazaTransporter
 * @package Wienkit\BolPlazaClient\Entities
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
