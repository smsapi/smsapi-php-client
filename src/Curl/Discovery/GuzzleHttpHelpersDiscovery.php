<?php

declare(strict_types=1);

namespace Smsapi\Client\Curl\Discovery;

use RuntimeException;

/**
 * @internal
 * @todo switch to composer-runtime-api
 */
class GuzzleHttpHelpersDiscovery
{
    public static function run()
    {
        if (!class_exists('GuzzleHttp\Psr7\Utils')) {
            throw new RuntimeException(
                'Guzzle HTTP helpers not found. Run `composer require guzzlehttp/psr7:^1`'
            );
        }
    }
}