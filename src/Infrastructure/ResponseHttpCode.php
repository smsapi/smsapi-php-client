<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure;

/**
 * @internal
 */
class ResponseHttpCode
{
    const OK = 200;
    const CREATED = 201;
    const ACCEPTED = 202;
    const NO_CONTENT = 204;
    const SERVICE_UNAVAILABLE = 503;
}
