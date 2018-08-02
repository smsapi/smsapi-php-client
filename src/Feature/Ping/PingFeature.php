<?php
declare(strict_types=1);

namespace Smsapi\Client\Feature\Ping;

use Smsapi\Client\Feature\Ping\Data\Ping;

/**
 * @api
 */
interface PingFeature
{
    public function ping(): Ping;
}
