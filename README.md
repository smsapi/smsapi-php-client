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

Starting from version 3, SMSAPI PHP Client supports PSR-17 and PSR-18 compliant HTTP clients.
That way this library is independent of client of your choice.
You have to provide HTTP client, request factory and stream factory to use our library.

For your convenience we provide an adapter for Curl. To use it you have to enable PHP curl extension and install some HTTP helpers:

```
composer require guzzlehttp/psr7:^1
```

Example below shows how to make use of that adapter (pay attention to namespace *Smsapi\Client\Curl*):

```php
<?php

declare(strict_types=1);

use Smsapi\Client\Curl\SmsapiHttpClient;

require_once 'vendor/autoload.php';

$client = new SmsapiHttpClient();
```

If your are not willing to use Curl as HTTP client then you have to provide your own HTTP client, request factory and
stream factory, as in example below (pay attention to namespace *Smsapi\Client*):

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
require_once 'your-own-psr18-stuff.php';

$client = new SmsapiHttpClient($httpClient, $requestFactory, $streamFactory);
```

All following examples consider you have client well-defined in `client.php` file.

### How to use *SMSAPI.COM* service?

```php
<?php

declare(strict_types=1);

use Smsapi\Client\SmsapiClient;

require_once 'vendor/autoload.php';

/**
 * @var SmsapiClient $client
 */
require_once 'client.php';

$apiToken = '0000000000000000000000000000000000000000';

$service = $client->smsapiComService($apiToken);
```

### How to use *SMSAPI.PL* service?

```php
<?php

declare(strict_types=1);

use Smsapi\Client\SmsapiClient;

require_once 'vendor/autoload.php';

/**
 * @var SmsapiClient $client
 */
require_once 'client.php';

$apiToken = '0000000000000000000000000000000000000000';

$service = $client->smsapiPlService($apiToken);
``` 

### How to use *SMSAPI.SE* or *SMSAPI.BG* services?

```php
<?php

declare(strict_types=1);

use Smsapi\Client\SmsapiClient;

require_once 'vendor/autoload.php';

/**
 * @var SmsapiClient $client
 */
require_once 'client.php';

$apiToken = '0000000000000000000000000000000000000000';
$uri = 'https://smsapi.io/';

$service = $client->smsapiComServiceWithUri($apiToken, $uri);
```

## How to use service business features?

All following examples consider you have an account on SMSAPI.COM and service has been setup in `service.php` file.

### How to use ping feature?

```php
<?php

declare(strict_types=1);

use Smsapi\Client\Service\SmsapiComService;

/** @var SmsapiComService $service */
require_once 'service.php';

$result = $service->pingFeature()
    ->ping();

if ($result->authorized) {
    echo 'Authorized';
} else {
    echo 'Not authorized';
}
```

### How to send a SMS?

```php
<?php

declare(strict_types=1);

use Smsapi\Client\Service\SmsapiComService;
use Smsapi\Client\Feature\Sms\Bag\SendSmsBag;

/** @var SmsapiComService $service */
require_once 'service.php';

$sms = SendSmsBag::withMessage('someone phone number', 'some message');

$service->smsFeature()
    ->sendSms($sms);
```

### How to send a SMS with optional from field?

```php
<?php

declare(strict_types=1);

use Smsapi\Client\Service\SmsapiComService;
use Smsapi\Client\Feature\Sms\Bag\SendSmsBag;

/** @var SmsapiComService $service */
require_once 'service.php';

$sms = SendSmsBag::withMessage('someone phone number', 'some message');
$sms->from = 'Test';

$service->smsFeature()
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

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;
use Smsapi\Client\SmsapiClient;

require_once 'vendor/autoload.php';

/**
 * @var SmsapiClient $client
 */
require_once 'client.php';

$logger = new class() implements LoggerInterface
{
    use LoggerTrait;
    
    public function log($level, $message, array $context = [])
    {
        var_dump($level, $message, $context);
    }
};

$client->setLogger($logger);
```

## How to test package

Copy `phpunit.dist.xml` to `phpunit.xml`. You may adjust it to your needs then.

Copy `tests-resources/config/config.dist.yml` to `tests-resources/config/config.yml`. Fill in SMSAPI service connection data.

### How to run unit tests

Unit tests are included into package build process and run against its current version on every commit (see `.travis.yml`).
You can run those tests locally with ease using provided Docker configuration, simply run:

```shell
make test-suite SUITE="unit"
```

### How to run integration tests

Note that integration test works within an account you have configured in `tests-resources/config/config.yml`. 
Although those test have been written to self-cleanup on exit, in case of failure some trash data may stay.
Use it with caution.

```shell
make test-suite SUITE="integration"
```

### How to run feature tests

Feature test groups are defined in `phpunit.dist.xml`. To run tests execute:

```shell
make test-suite SUITE="feature-contacts"
```

### How to run tests against PHP8

To run any of mentioned above against PHP8 use make targets with `php8` suffix. See `Makefile.php8`.

## Docs & Infos
* [SMSAPI.COM API documentation](https://www.smsapi.com/docs)
* [SMSAPI.PL API documentation](https://www.smsapi.pl/docs)
* [SMSAPI.SE API documentation](https://www.smsapi.se/docs)
* [SMSAPI.BG API documentation](https://www.smsapi.bg/docs)
* [SMSAPI.COM web page](https://smsapi.com)
* [SMSAPI.PL web page](https://smsapi.pl)
* [SMSAPI.SE web page](https://smsapi.se)
* [SMSAPI.BG web page](https://smsapi.bg)
* [Repository on GitHub](https://github.com/smsapi/smsapi-php-client)
* [Package on Packagist](https://packagist.org/packages/smsapi/php-client)
