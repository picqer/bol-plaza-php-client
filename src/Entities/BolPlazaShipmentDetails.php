<?php

namespace Picqer\BolPlazaClient\Entities;

/**
 * Class BolPlazaShipmentDetails
 * @package Picqer\BolPlazaClient\Entities
 *
 * @param string $SalutationCode
 * @param string $FirstName
 * @param string $Surname
 * @param string $Streetname
 * @param string $Housenumber
 * @param string $HousenumberExtended
 * @param string $AddressSupplement
 * @param string $ZipCode
 * @param string $City
 * @param string $CountryCode
 * @param string $Email
 * @param string $Telephone
 * @param string $Company
 */
class BolPlazaShipmentDetails extends BaseModel {

    protected $xmlEntityName = 'ShipmentDetails';

    protected $attributes = [
        'SalutationCode',
        'FirstName',
        'Surname',
        'Streetname',
        'Housenumber',
        'HousenumberExtended',
        'AddressSupplement',
        'ZipCode',
        'City',
        'CountryCode',
        'Email',
        'Telephone',
        'Company'
    ];

}