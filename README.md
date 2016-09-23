# Bol.com Plaza API client for PHP
[![Latest Stable Version](https://poser.pugx.org/wienkit/bol-plaza-php-client/v/stable)](https://packagist.org/packages/wienkit/bol-plaza-php-client)
[![Total Downloads](https://poser.pugx.org/wienkit/bol-plaza-php-client/downloads)](https://packagist.org/packages/wienkit/bol-plaza-php-client)
[![Latest Unstable Version](https://poser.pugx.org/bol-plaza-php-client/v/unstable)](https://packagist.org/packages/wienkit/bol-plaza-php-client)
[![License](https://poser.pugx.org/wienkit/bol-plaza-php-client/license)](https://packagist.org/packages/wienkit/bol-plaza-php-client)
[![composer.lock](https://poser.pugx.org/wienkit/bol-plaza-php-client/composerlock)](https://packagist.org/packages/wienkit/bol-plaza-php-client)

This is an open source PHP client for the [Bol.com Plaza API](https://developers.bol.com/documentatie/plaza-api/).

## Installation
Get it with [composer](https://getcomposer.org)

Run the command:
```
composer require wienkit/bol-plaza-php-client
```

## Example: get open orders
```php
<?php

require __DIR__ . '/vendor/autoload.php';

$publickey = '--YOUR PUBLIC KEY--';
$privatekey = '--YOUR PRIVATE KEY--';

$client = new Wienkit\BolPlazaClient\BolPlazaClient($publickey, $privatekey);

$orders = $client->getOrders();

var_dump($orders);
```

See the tests folder for more information
