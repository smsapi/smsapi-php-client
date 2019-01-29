<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Sms\Data;

/**
 * @internal
 */
class SmsContentFactory
{
    public function create(string $message, int $length, int $parts): SmsContent
    {
        $smsDetails = new SmsContent();

        $smsDetails->message = $message;
        $smsDetails->length = $length;
        $smsDetails->parts = $parts;

        return $smsDetails;
    }
}
