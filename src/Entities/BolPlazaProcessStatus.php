<?php

namespace Picqer\BolPlazaClient\Entities;

/**
 * Class BolPlazaProcessStatus
 * @package Picqer\BolPlazaClient\Entities
 *
 * @property string id
 * @property string sellerId
 * @property string entityId
 * @property string eventType
 * @property string description
 * @property string status
 * @property string createTimestamp
 */
class BolPlazaProcessStatus extends BaseModel {

    protected $xmlEntityName = 'ProcessStatus';
    protected $xmlNamespace = 'ns1';

    protected $attributes = [
        'id',
        'sellerId',
        'entityId',
        'eventType',
        'description',
        'status',
        'errorMessage',
        'createTimestamp'
    ];
}
