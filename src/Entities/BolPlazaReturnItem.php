<?php

namespace Picqer\BolPlazaClient\Entities;

/**
 * Class BolPlazaReturnItem
 * @package Picqer\BolPlazaClient\Entities
 *
 * @param string $ReturnNumber
 * @param string $OrderId
 * @param string $ShipmentId
 * @param string $EAN
 * @param string $Title
 * @param string $Quantity
 * @param string $ReturnDateAnnouncement
 * @param string $ReturnReason
 * @param string $OfferCondition
 */
class BolPlazaReturnItem extends BaseModel {

    protected $xmlEntityName = 'Item';

    protected $attributes = [
        'ReturnNumber',
        'OrderId',
        'ShipmentId',
        'EAN',
        'Title',
        'Quantity',
        'ReturnDateAnnouncement',
        'ReturnReason'
    ];

    protected $nestedEntities = [
        'CustomerDetails' => 'BolPlazaShipmentDetails',
    ];
}
