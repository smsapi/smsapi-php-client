<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Sms\Data;

/**
 * @api
 */
class SmsContent
{
    /** @var string */
    public $message;

    /** @var int */
    public $length;

    /** @var int */
    public $parts;
}
