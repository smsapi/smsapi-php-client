<?php

declare(strict_types=1);

namespace Smsapi\Client\Curl;

use RuntimeException;

/**
 * @internal
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