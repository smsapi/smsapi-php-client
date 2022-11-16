<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Blacklist\Bag;

use Smsapi\Client\Feature\Bag\PaginationBag;

/**
 * @api
 * @property string $q
 */
#[\AllowDynamicProperties]
class FindBlacklistedPhoneNumbersBag
{
    use PaginationBag;
}
