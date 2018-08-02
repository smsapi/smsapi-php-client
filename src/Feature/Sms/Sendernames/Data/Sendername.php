<?php
declare(strict_types=1);

namespace Smsapi\Client\Feature\Sms\Sendernames\Data;

use DateTimeInterface;

/**
 * @api
 */
class Sendername
{
    /** @var string */
    public $sender;

    /** @var bool */
    public $isDefault;

    /** @var string */
    public $status;

    /** @var DateTimeInterface */
    public $createdAt;
}
