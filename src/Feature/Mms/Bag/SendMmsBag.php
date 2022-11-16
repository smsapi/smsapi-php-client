<?php
declare(strict_types=1);

namespace Smsapi\Client\Feature\Mms\Bag;

/**
 * @api
 * @property bool $test
 */
#[\AllowDynamicProperties]
class SendMmsBag
{

    /** @var string */
    public $to;

    /** @var string */
    public $subject;

    /** @var string */
    public $smil;

    public function __construct(string $receiver, string $subject, string $smil)
    {
        $this->to = $receiver;
        $this->subject = $subject;
        $this->smil = $smil;
    }
}
