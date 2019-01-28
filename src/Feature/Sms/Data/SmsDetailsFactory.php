<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Sms\Data;

/**
 * @internal
 */
class SmsDetailsFactory
{
    public function create(string $message, int $length, int $parts): SmsDetails
    {
        $smsDetails = new SmsDetails();

        $smsDetails->message = $message;
        $smsDetails->length = $length;
        $smsDetails->parts = $parts;

        return $smsDetails;
    }
}
