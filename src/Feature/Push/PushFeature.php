<?php
declare(strict_types=1);

namespace Smsapi\Client\Feature\Push;

use Smsapi\Client\Feature\Push\Bag\SendPushBag;
use Smsapi\Client\Feature\Push\Data\PushShipment;

/**
 * @api
 * @deprecated
 */
interface PushFeature
{
    public function createPush(SendPushBag $sendPushBag): PushShipment;
}
