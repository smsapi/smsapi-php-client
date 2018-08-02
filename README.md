# SMSAPI PHP Client

[![Build Status](https://travis-ci.org/smsapi/smsapi-php-client.svg?branch=master)](https://travis-ci.org/smsapi/smsapi-php-client)

## Requirements

* [composer](https://getcomposer.org/)

## Install package with dependencies

Execute: `composer require smsapi/php-client`

## How to use *SMSAPI.COM* client?

### How to ping service?

```php
<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use Smsapi\Client\SmsapiHttpClient;

$apiToken = '0000000000000000000000000000000000000000';

$result = (new SmsapiHttpClient)
    ->smsapiComService($apiToken)
    ->pingFeature()
    ->ping();

if ($result->smsapi) {
    echo 'SMSAPI active';
} else {
    echo 'SMSAPI not active';
}
```

### How to use custom URI?

```php
<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use Smsapi\Client\SmsapiHttpClient;

$apiToken = '0000000000000000000000000000000000000000';
$uri = 'http://example.com';

(new SmsapiHttpClient)->smsapiComServiceWithUri($apiToken, $uri);
```

## How to use *SMSAPI.PL* client?

### How to ping service?

```php
<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use Smsapi\Client\SmsapiHttpClient;

$apiToken = '0000000000000000000000000000000000000000';

$result = (new SmsapiHttpClient)
    ->smsapiPlService($apiToken)
    ->pingFeature()
    ->ping();

if ($result->smsapi) {
    echo 'SMSAPI active';
} else {
    echo 'SMSAPI not active';
}
```

### How to use custom URI?

```php
<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use Smsapi\Client\SmsapiHttpClient;

$apiToken = '0000000000000000000000000000000000000000';
$uri = 'http://example.com';

(new SmsapiHttpClient)->smsapiPlServiceWithUri($apiToken, $uri);
```

## Additional features

### How to use proxy server?

```php
<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use Smsapi\Client\SmsapiHttpClient;

$proxyUrl = 'https://example.org';

(new SmsapiHttpClient)->setProxy($proxyUrl);
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

(new SmsapiHttpClient)->setLogger($logger);
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