<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Fixture;

use Smsapi\Client\Infrastructure\HttpClient\HttpClientFactory;

class HttpClientFactoryMother
{
    public static function any(): HttpClientFactory
    {
        return new HttpClientFactory('any api token', 'any uri');
    }
}
