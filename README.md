php-client
==========

Klient PHP pozwalający na wysyłanie wiadomości SMS, MMS, VMS oraz zarządzanie kontem w serwisie SMSAPI.pl

```php
<?php

require_once 'smsapi/Autoload.php';

$client = new \SMSApi\Client('login');
$client->setPasswordHash( md5('super tajne haslo') );

$smsapi = new \SMSApi\Api\SmsFactory();
$smsapi->setClient($client);

try {

	$actionSend = $smsapi->actionSend();

	$actionSend->setTo('600xxxxxx');
	$actionSend->setText('Hello World!!');
	$actionSend->setSender('Info'); //Pole nadawcy lub typ wiadomość 'ECO', '2Way'

	$response = $actionSend->execute();

	foreach( $response->getList() as $status ) {
		echo  $status->getNumber() . ' ' . $status->getPoints() . ' ' . $status->getStatus();
	}
}
catch( \SMSApi\Exception\SmsapiException $e ) {
	echo 'ERROR: ' . $e->getMessage();
}
```

[Dokumentacja API biblioteki.](https://github.com/smsapi/smsapi-php-client/wiki)

Sprawdź na przykładach, w jaki sposób można korzystać z biblioteki ([examples](https://github.com/smsapi/smsapi-php-client/wiki/Examples)).

## Wymagania

* PHP >= 5.3
* allow_url_fopen lub rozszerzenie curl

## Instalacja

W swoim projekcie dodaj do `composer.json` pakiet :

    {
        "require": {
            "smsapi/php-client": "1.2.*"
        }
    }

## Licencja
[Apache 2.0 License](https://github.com/smsapi/smsapi-php-client/blob/master/LICENSE)
