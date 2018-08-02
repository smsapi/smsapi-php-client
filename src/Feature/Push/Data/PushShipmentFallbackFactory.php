<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Push\Data;

/**
 * @internal
 */
class PushShipmentFallbackFactory
{
    public function createFromObject(\stdClass $object): PushShipmentFallback
    {
        $fallback = new PushShipmentFallback();
        $fallback->message = $object->message;
        $fallback->from = $object->from;
        $fallback->delay = $object->delay;
        $fallback->status = $object->status;

        return $fallback;
    }
}
