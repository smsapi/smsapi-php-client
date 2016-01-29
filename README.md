﻿# SMSAPI PHP Client

Klient PHP pozwalający na wysyłanie wiadomości SMS, MMS, VMS oraz zarządzanie kontem w serwisie SMSAPI.pl

```php
<?php

use SMSApi\Client;
use SMSApi\Api\SmsFactory;
use SMSApi\Exception\SmsapiException;

require_once 'vendor/autoload.php';

$client = new Client('login');
$client->setPasswordHash(md5('super tajne haslo'));

$smsapi = new SmsFactory;
$smsapi->setClient($client);

try {
	$actionSend = $smsapi->actionSend();

	$actionSend->setTo('600xxxxxx');
	$actionSend->setText('Hello World!!');
	$actionSend->setSender('Info'); //Pole nadawcy, lub typ wiadomości: 'ECO', '2Way'

	$response = $actionSend->execute();

	foreach ($response->getList() as $status) {
		echo $status->getNumber() . ' ' . $status->getPoints() . ' ' . $status->getStatus();
	}
} catch (SmsapiException $exception) {
	echo 'ERROR: ' . $exception->getMessage();
}
```

Przykład zmiany adresu serwera na zapasowy:

```php
<?php

use SMSApi\Client;
use SMSApi\Api\SmsFactory;
use SMSApi\Proxy\Http\Native;

require_once 'vendor/autoload.php';

$client = new Client('login');
$client->setPasswordHash(md5('haslo'));

$proxy = new Native('https://api2.smsapi.pl'); // zapasowy serwer

$smsapi = new SmsFactory($proxy);
$smsapi->setClient($client);

$actionSend = $smsapi->actionSend();

$actionSend->setTo('600xxxxxx');
$actionSend->setText('Hello World!!');
$actionSend->setSender('Info');

foreach ($actionSend->execute()->getList() as $status) {
    echo $status->getNumber() . ' ' . $status->getPoints() . ' ' . $status->getStatus();
}
```

[Dokumentacja API biblioteki.](https://github.com/smsapi/smsapi-php-client/wiki)

Sprawdź na przykładach, w jaki sposób można korzystać z biblioteki ([examples](https://github.com/smsapi/smsapi-php-client/wiki/Examples)).

## Wymagania

* PHP >= 5.3
* allow_url_fopen lub rozszerzenie curl

## Instalacja

Otwórz konsolę poleceń, przejdź do katalog projektu i wykonać następujące polecenie, aby pobrać najnowszą stabilną wersję:

```
composer require smsapi.pl/php-client
```

## Licencja
[Apache 2.0 License](LICENSE)
