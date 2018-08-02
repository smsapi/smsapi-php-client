<?php
declare(strict_types=1);

namespace Smsapi\Client\Feature\Push\Data;

use DateTimeInterface;

/**
 * @api
 */
class PushShipment
{
    /** @var string */
    public $id;

    /** @var string */
    public $appId;

    /** @var string */
    public $status;

    /** @var DateTimeInterface */
    public $dateCreated;

    /** @var DateTimeInterface */
    public $scheduledDate;

    /** @var PushShipmentPayload */
    public $payload;

    /** @var PushShipmentSummary */
    public $summary;

    /** @var PushShipmentDispatchDetails */
    public $dispatchDetails;

    /** @var PushShipmentFallback */
    public $fallback;

    /** @var PushApp */
    public $app;
}
