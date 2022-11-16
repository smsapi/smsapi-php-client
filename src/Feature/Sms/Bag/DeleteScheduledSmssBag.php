<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Sms\Bag;

/**
 * @api
 */
#[\AllowDynamicProperties]
class DeleteScheduledSmssBag
{
    /** @var array */
    public $smsIds;

    public function __construct(array $smsIds)
    {
        $this->smsIds = $smsIds;
    }
}
