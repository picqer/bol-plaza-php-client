<?php

namespace Picqer\BolPlazaClient\Entities;

/**
 * Class BolPlazaPaymentShipmentItem
 * @package Picqer\BolPlazaClient\Entities
 *
 * @property string $OrderItemId
 * @property string $EAN
 * @property string $OfferReference
 * @property string $Quantity
 * @property string $OfferPrice
 * @property string $ShippingContribution
 * @property string $TransactionFee
 * @property string $TotalAmount
 * @property string $ShipmentStatus
 */
class BolPlazaPaymentShipmentItem extends BaseModel {

    protected $xmlEntityName = 'PaymentShipmentItem';

    protected $attributes = [
        'OrderItemId',
        'EAN',
        'OfferReference',
        'Quantity',
        'OfferPrice',
        'ShippingContribution',
        'TransactionFee',
        'TotalAmount',
        'ShipmentStatus'
    ];

}
