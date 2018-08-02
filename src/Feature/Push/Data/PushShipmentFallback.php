<?php
declare(strict_types=1);

namespace Smsapi\Client\Feature\Push\Data;

/**
 * @api
 */
class PushShipmentFallback
{
    /** @var string */
    public $message;

    /** @var string */
    public $from;

    /** @var int */
    public $delay;

    /** @var string|null */
    public $status;
}
