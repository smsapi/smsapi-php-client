<?php
declare(strict_types=1);

namespace Smsapi\Client\Feature\Ping\Data;

/**
 * @api
 */
class Ping
{
    /** @var bool */
    public $authorized;

    /** @var array */
    public $unavailable;
}
