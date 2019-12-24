<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Blacklist;

use Smsapi\Client\Feature\Blacklist\Bag\CreateBlacklistedPhoneNumberBag;
use Smsapi\Client\Feature\Blacklist\Bag\FindBlacklistedPhoneNumbersBag;
use Smsapi\Client\Feature\Blacklist\Data\BlacklistedPhoneNumber;

/**
 * @api
 */
interface BlacklistFeature
{
    public function createBlacklistedPhoneNumber(CreateBlacklistedPhoneNumberBag $createBlacklistedPhoneNumberBag): BlacklistedPhoneNumber;

    public function findBlacklistedPhoneNumbers(FindBlacklistedPhoneNumbersBag $blacklistPhoneNumbersFindBag): array;

    public function deleteBlacklistedPhoneNumber(Bag\DeleteBlacklistedPhoneNumberBag $blacklistPhoneNumberDeleteBag);

    public function deleteBlacklistedPhoneNumbers();
}