<?php

namespace Picqer\BolPlazaClient\Entities;

/**
 * Class BolPlazaOrderItem
 * @package Picqer\BolPlazaClient\Entities
 *
 * @param string $OrderItemId
 * @param string $EAN
 * @param string $OfferReference
 * @param string $Title
 * @param string $Quantity
 * @param string $OfferPrice
 * @param string $PromisedDeliveryDate
 * @param string $TransactionFee
 * @param string $OfferCondition
 * @param string $CancelRequest
 */
class BolPlazaOrderItem extends BaseModel {

    protected $xmlEntityName = 'OrderItem';

    protected $attributes = [
        'OrderItemId',
        'EAN',
        'OfferReference',
        'Title',
        'Quantity',
        'OfferPrice',
        'TransactionFee',
        'PromisedDeliveryDate',
        'OfferCondition',
        'CancelRequest'
    ];

}
