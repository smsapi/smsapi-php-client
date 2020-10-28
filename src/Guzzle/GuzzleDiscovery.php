<?php

declare(strict_types=1);

namespace Smsapi\Client\Guzzle;

class GuzzleDiscovery
{
    public static function run()
    {
        if (!class_exists('GuzzleHttp\Client')) {
            throw new \RuntimeException(
                'Guzzle not found. To install it run \'composer require guzzlehttp/guzzle\' in your project'
            );
        }
    }
}