<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Ping\Data;

use stdClass;

class PingFactory
{
    public function createFromObject(stdClass $result): Ping
    {
        $ping = new Ping();
        $ping->authorized = $result->authorized;
        $ping->unavailable = $result->unavailable;

        return $ping;
    }
}