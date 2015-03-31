# SMSAPI PHP Client

Klient PHP pozwalający na wysyłanie wiadomości SMS, MMS, VMS oraz zarządzanie kontem w serwisie SMSAPI.pl

```php
<?php

use SMSApi\Client;
use SMSApi\Api\SmsFactory;
use SMSApi\Exception\SmsapiException;

require_once 'vendor/autoload.php';

$client = new Client('login');
$client->setPasswordHash( md5('super tajne haslo') );

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

[Dokumentacja API biblioteki.](https://github.com/smsapi/smsapi-php-client/wiki)

Sprawdź na przykładach, w jaki sposób można korzystać z biblioteki ([examples](https://github.com/smsapi/smsapi-php-client/wiki/Examples)).

## Wymagania

* PHP >= 5.3
* allow_url_fopen lub rozszerzenie curl

## Instalacja

W swoim projekcie dodaj do `composer.json` pakiet :

```json
{
    "require": {
        "smsapi/php-client": "1.3.*"
    }
}
```

## Licencja
[Apache 2.0 License](LICENSE)
