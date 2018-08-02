<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Push\Data;

/**
 * @internal
 */
class PushShipmentPayloadFactory
{
    public function createFromObject(\stdClass $object): PushShipmentPayload
    {
        $payload = new PushShipmentPayload();
        $payload->alert = $object->alert;

        return $payload;
    }
}
