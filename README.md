# Bol.com Plaza API client for PHP
Work in progress, but this will be an open source PHP client for the Bol.com Plaza API.

## Installation
WIP: Will be on Packagist

## Example: get open orders
```php
<?php

require __DIR__ . '/vendor/autoload.php';

$publickey = '--YOUR PUBLIC KEY--';
$privatekey = '--YOUR PRIVATE KEY--';

$client = new Picqer\BolPlazaClient\BolPlazaClient($publickey, $privatekey);

$orders = $client->getOpenOrders();

var_dump($orders);
```

## Example: Update shipment
```php
<?php

require __DIR__ . '/vendor/autoload.php';

$publickey = '--YOUR PUBLIC KEY--';
$privatekey = '--YOUR PRIVATE KEY--';

$client = new Picqer\BolPlazaClient\BolPlazaClient($publickey, $privatekey);

$shipment = new Picqer\BolPlazaClient\Entities\BolPlazaShipment();
$shipment->OrderId = 1234;
$shipment->DateTime = "2011-01-01T12:00:00";
$transporter = new Picqer\BolPlazaClient\Entities\BolPlazaTransporter();
$transporter->Code = 'TNT';
$transporter->TrackAndTraceCode = '3SLGCT01238190283';
$shipment->Transporter = $transporter;
$shipment->OrderItems = ['1231'];

$shipments = [$shipment];

$client->processShipments($shipments);
```
