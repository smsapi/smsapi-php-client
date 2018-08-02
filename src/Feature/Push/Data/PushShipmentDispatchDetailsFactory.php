<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Push\Data;

/**
 * @internal
 */
class PushShipmentDispatchDetailsFactory
{
    public function createFromObject(\stdClass $object): PushShipmentDispatchDetails
    {
        $details = new PushShipmentDispatchDetails();
        $details->channels = $object->channels;
        $details->deviceIds = $object->device_ids;
        $details->deviceType = $object->device_type;

        return $details;
    }
}
