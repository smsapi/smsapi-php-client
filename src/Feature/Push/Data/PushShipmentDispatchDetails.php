<?php
declare(strict_types=1);

namespace Smsapi\Client\Feature\Push\Data;

/**
 * @api
 */
class PushShipmentDispatchDetails
{
    /** @var array */
    public $channels;

    /** @var array */
    public $deviceIds;

    /** @var array */
    public $deviceType;
}
