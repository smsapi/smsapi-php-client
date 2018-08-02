<?php
declare(strict_types=1);

namespace Smsapi\Client\Feature\Push\Data;

/**
 * @api
 */
class PushShipmentSummary
{
    /** @var float */
    public $points;

    /** @var int */
    public $recipientsCount;

    /** @var null|string */
    public $errorCode;
}
