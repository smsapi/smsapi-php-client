<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Blacklist\Data;

use DateTimeImmutable;
use stdClass;

/**
 * @internal
 */
class BlacklistedPhoneNumberFactory
{
    public function createFromObject(stdClass $result): BlacklistedPhoneNumber
    {
        $blacklistedPhoneNumber = new BlacklistedPhoneNumber();
        $blacklistedPhoneNumber->id = $result->id;
        $blacklistedPhoneNumber->phoneNumber = $result->phone_number;
        $blacklistedPhoneNumber->createdAt = new DateTimeImmutable($result->created_at);

        if ($result->expire_at) {
            $blacklistedPhoneNumber->expireAt = new DateTimeImmutable($result->expire_at);
        }

        return $blacklistedPhoneNumber;
    }
}
