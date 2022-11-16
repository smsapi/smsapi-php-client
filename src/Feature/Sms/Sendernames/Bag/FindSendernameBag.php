<?php
declare(strict_types=1);

namespace Smsapi\Client\Feature\Sms\Sendernames\Bag;

/**
 * @api
 */
#[\AllowDynamicProperties]
class FindSendernameBag
{
    public $sender;

    public function __construct(string $sender)
    {
        $this->sender = $sender;
    }
}
