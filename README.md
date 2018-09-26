# SMSAPI PHP Client

[![Build Status](https://travis-ci.org/smsapi/smsapi-php-client.svg?branch=master)](https://travis-ci.org/smsapi/smsapi-php-client)
[![Packagist - latest version](https://img.shields.io/packagist/v/smsapi/php-client.svg)](https://packagist.org/packages/smsapi/php-client)
[![Packagist - downloads](https://img.shields.io/packagist/dt/smsapi/php-client.svg)](https://packagist.org/packages/smsapi/php-client)
[![Packagist - license](https://img.shields.io/packagist/l/smsapi/php-client.svg)](https://packagist.org/packages/smsapi/php-client)
## Developer version:
## Requirements

* [composer](https://getcomposer.org/)

## Install package with dependencies

Execute: 
* stable version: `composer require smsapi/php-client`
* developer version: `composer require smsapi/php-client:master@dev`

## How to pick a service

Depending on which of SMSAPI service your account is, you should pick it calling one of a method from examples below:

### How to use *SMSAPI.COM* client?

```php
<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use Smsapi\Client\SmsapiHttpClient;

$apiToken = '0000000000000000000000000000000000000000';

$service = (new SmsapiHttpClient())
    ->smsapiComService($apiToken);
```

### How to use *SMSAPI.PL* client?

```php
<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use Smsapi\Client\SmsapiHttpClient;

$apiToken = '0000000000000000000000000000000000000000';

$service = (new SmsapiHttpClient())
    ->smsapiPlService($apiToken);
```

All following examples consider you have a account on SMSAPI.COM. 

## How to use a custom URI?

```php
<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use Smsapi\Client\SmsapiHttpClient;

$apiToken = '0000000000000000000000000000000000000000';
$uri = 'http://example.com';

$service = (new SmsapiHttpClient())
    ->smsapiComServiceWithUri($apiToken, $uri);
```

## How to use service business features?

### How to use ping feature?

```php
<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use Smsapi\Client\SmsapiHttpClient;

$apiToken = '0000000000000000000000000000000000000000';

$service = (new SmsapiHttpClient())
    ->smsapiComService($apiToken);
$result = $service->pingFeature()
    ->ping();

if ($result->smsapi) {
    echo 'SMSAPI active';
} else {
    echo 'SMSAPI not active';
}
```

### How to send a SMS?

```php
<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use Smsapi\Client\SmsapiHttpClient;
use Smsapi\Client\Feature\Sms\Bag\SendSmsBag;

$apiToken = '0000000000000000000000000000000000000000';

$sms = SendSmsBag::withMessage('someone phone number', 'some message');

$service = (new SmsapiHttpClient())
    ->smsapiComService($apiToken);
$service->smsFeature()
    ->sendSms($sms);
```

For more usage examples take a look at client test suite. 

## How to use additional features?

### How to use proxy server?

```php
<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use Smsapi\Client\SmsapiHttpClient;

$proxyUrl = 'https://example.org';

(new SmsapiHttpClient())->setProxy($proxyUrl);
```

### How to log requests and responses?

Set logger to `SmsapiHttpClient` instance.

```php
<?php

declare(strict_types=1);

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

require_once 'vendor/autoload.php';

use Smsapi\Client\SmsapiHttpClient;

$logger = new class() implements LoggerInterface
{
    use LoggerTrait;
    
    public function log($level, $message, array $context = [])
    {
        var_dump($level, $message, $context);
    }
};

(new SmsapiHttpClient())->setLogger($logger);
```

## Test package
1. Download package: `composer create-project smsapi/php-client`
2. Execute tests: `./vendor/bin/phing`

## More info
* [SMSAPI.COM API documentation](https://docs.smsapi.com)
* [Repository on GitHub](https://github.com/smsapi/smsapi-php-client)
* [Package on Packagist](https://packagist.org/packages/smsapi/php-client)
* [SMSAPI.COM web page](https://smsapi.com)
* [SMSAPI.PL web page](https://smsapi.pl)
