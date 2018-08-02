<?php
declare(strict_types=1);

namespace Smsapi\Client\Tests;

use MabeEnum\Enum;

/**
 * @method static ServiceName SMSAPI_PL
 * @method static ServiceName SMSAPI_COM
 * @method static ServiceName byValue($value)
 */
class ServiceName extends Enum
{
    const SMSAPI_PL = 'SMSAPI.PL';
    const SMSAPI_COM = 'SMSAPI.COM';
}
