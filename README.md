# SMSAPI PHP Client

[![Build Status](https://travis-ci.org/smsapi/smsapi-php-client.svg?branch=master)](https://travis-ci.org/smsapi/smsapi-php-client)
[![Packagist - latest version](https://img.shields.io/packagist/v/smsapi/php-client.svg)](https://packagist.org/packages/smsapi/php-client)
[![Packagist - downloads](https://img.shields.io/packagist/dt/smsapi/php-client.svg)](https://packagist.org/packages/smsapi/php-client)
[![Packagist - license](https://img.shields.io/packagist/l/smsapi/php-client.svg)](https://packagist.org/packages/smsapi/php-client)

**[Version 1.8.7 available here](https://github.com/smsapi/smsapi-php-client/tree/v1.8.7)**

**[SMSAPI.COM API documentation](https://www.smsapi.com/docs)**

**[SMSAPI.PL API documentation](https://www.smsapi.pl/docs)**

## Requirements

* [composer](https://getcomposer.org/)

## Install package with dependencies

Execute: `composer require smsapi/php-client`

## How to pick a service

Depending on which of SMSAPI service your account is, you should pick it calling one of a method from examples below:

### PSR-17 and PSR-18

Starting form version 3, SMSAPI PHP Client supports PSR-17 and PSR-18 compliant HTTP clients.
That way this library is independent of client of your choice.
You have to provide your own HTTP client, request factory and stream factory to use our library.
All following examples consider you have HTTP client, request factory and stream factory well-defined in `bootstrap.php` file.

### How to use *SMSAPI.COM* client?

```php
<?php

declare(strict_types=1);

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Smsapi\Client\SmsapiHttpClient;

require_once 'vendor/autoload.php';

/**
 * @var ClientInterface $httpClient
 * @var RequestFactoryInterface $requestFactory
 * @var StreamFactoryInterface $streamFactory
 */
require_once 'bootstrap.php';

$apiToken = '0000000000000000000000000000000000000000';

$client = (new SmsapiHttpClient($httpClient, $requestFactory, $streamFactory))
    ->smsapiComService($apiToken);
```

### How to use *SMSAPI.PL* client?

```php
<?php

declare(strict_types=1);

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Smsapi\Client\SmsapiHttpClient;

require_once 'vendor/autoload.php';

/**
 * @var ClientInterface $httpClient
 * @var RequestFactoryInterface $requestFactory
 * @var StreamFactoryInterface $streamFactory
 */
require_once 'bootstrap.php';

$apiToken = '0000000000000000000000000000000000000000';

$client = (new SmsapiHttpClient($httpClient, $requestFactory, $streamFactory))
    ->smsapiPlService($apiToken);
``` 

## How to use a custom URI?

```php
<?php

declare(strict_types=1);

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Smsapi\Client\SmsapiHttpClient;

require_once 'vendor/autoload.php';

/**
 * @var ClientInterface $httpClient
 * @var RequestFactoryInterface $requestFactory
 * @var StreamFactoryInterface $streamFactory
 */
require_once 'bootstrap.php';

$apiToken = '0000000000000000000000000000000000000000';
$uri = 'http://example.com';

$client = (new SmsapiHttpClient($httpClient, $requestFactory, $streamFactory))
    ->smsapiComServiceWithUri($apiToken, $uri);
```

## How to use service business features?

All following examples consider you have an account on SMSAPI.COM and client has been setup in `client.php` file.

### How to use ping feature?

```php
<?php

declare(strict_types=1);

use Smsapi\Client\Service\SmsapiComService;

/** @var SmsapiComService $client */
require_once 'client.php';

$result = $client->pingFeature()
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

use Smsapi\Client\Service\SmsapiComService;
use Smsapi\Client\Feature\Sms\Bag\SendSmsBag;

/** @var SmsapiComService $client */
require_once 'client.php';

$sms = SendSmsBag::withMessage('someone phone number', 'some message');

$client->smsFeature()
    ->sendSms($sms);
```

### How to send a SMS with optional from field?

```php
<?php

declare(strict_types=1);

use Smsapi\Client\Service\SmsapiComService;
use Smsapi\Client\Feature\Sms\Bag\SendSmsBag;

/** @var SmsapiComService $client */
require_once 'client.php';

$sms = SendSmsBag::withMessage('someone phone number', 'some message');
$sms->from = 'Test';

$client->smsFeature()
    ->sendSms($sms);
```

For more usage examples take a look at client test suite.

### How to use optional request parameters?

Request parameters are represented in a form of data transfer object.
DTOs can be found by searching for 'bag' postfixed classes.
Each bag may contain required and optional parameters.
Required parameters are that class public properties, usually accessible via some form of a setter or named constructor.
Optional parameters are described by docblock's '@property' annotation.

Each parameter can be also set directly by setting bag property, as in example:

```php
<?php

declare(strict_types=1);

use Smsapi\Client\Feature\Sms\Bag\SendSmsBag;

$sms = SendSmsBag::withMessage('someone phone number', 'some message');
$sms->encoding = 'utf-8';

```

## How to use additional features?

### How to use proxy server?

To use proxy server you have to define it with your HTTP client. 

### How to log requests and responses?

Set logger to `SmsapiHttpClient` instance.

```php
<?php

declare(strict_types=1);

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;
use Smsapi\Client\SmsapiHttpClient;

require_once 'vendor/autoload.php';

/**
 * @var ClientInterface $httpClient
 * @var RequestFactoryInterface $requestFactory
 * @var StreamFactoryInterface $streamFactory
 */
require_once 'bootstrap.php';

$logger = new class() implements LoggerInterface
{
    use LoggerTrait;
    
    public function log($level, $message, array $context = [])
    {
        var_dump($level, $message, $context);
    }
};

(new SmsapiHttpClient($httpClient, $requestFactory, $streamFactory))
    ->setLogger($logger);
```

## Test package
1. Download package: `composer create-project smsapi/php-client`
2. Execute tests: `./vendor/bin/phing`

## Docs & Infos
* [SMSAPI.COM API documentation](https://www.smsapi.com/docs)
* [SMSAPI.PL API documentation](https://www.smsapi.pl/docs)
* [Repository on GitHub](https://github.com/smsapi/smsapi-php-client)
* [Package on Packagist](https://packagist.org/packages/smsapi/php-client)
* [SMSAPI.COM web page](https://smsapi.com)
* [SMSAPI.PL web page](https://smsapi.pl)
