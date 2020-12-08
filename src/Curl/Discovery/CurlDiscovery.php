<?php

declare(strict_types=1);

namespace Smsapi\Client\Curl\Discovery;

use RuntimeException;

/**
 * @internal
 * @todo switch to composer-runtime-api
 */
class CurlDiscovery
{
    public static function run()
    {
        if (!function_exists('curl_init')) {
            throw new RuntimeException(
                'CURL not found'
            );
        }
    }
}