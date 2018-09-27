<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Fixture;

use Http\Adapter\Guzzle6\Client;
use Psr\Http\Client\ClientInterface;

final class ClientInterfaceMother
{
    public static function any(): ClientInterface
    {
        return new Client();
    }
}
