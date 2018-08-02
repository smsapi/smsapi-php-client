<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Push\Data;

/**
 * @internal
 */
class PushShipmentSummaryFactory
{
    public function createFromObject(\stdClass $object): PushShipmentSummary
    {
        $summary = new PushShipmentSummary();
        $summary->points = (float)$object->points;
        $summary->recipientsCount = $object->recipients_count;
        $summary->errorCode = $object->error_code;

        return $summary;
    }
}
