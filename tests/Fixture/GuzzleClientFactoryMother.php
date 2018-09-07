<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Fixture;

use Smsapi\Client\Infrastructure\RequestExecutor\GuzzleClientFactory;

class GuzzleClientFactoryMother
{
    public static function any(): GuzzleClientFactory
    {
        return new GuzzleClientFactory('any api token', 'any uri', 'any proxy');
    }
}
