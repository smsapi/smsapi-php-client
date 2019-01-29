<?php
declare(strict_types=1);

namespace Smsapi\Client\Feature\Sms\Data;

use DateTimeInterface;

/**
 * @api
 */
class Sms
{
    /** @var string */
    public $id;

    /** @var float */
    public $points;

    /** @var string */
    public $number;

    /** @var DateTimeInterface */
    public $dateSent;

    /** @var string */
    public $status;

    /** @var string|null */
    public $idx;

    /** @var SmsContent|null */
    public $content;
}
