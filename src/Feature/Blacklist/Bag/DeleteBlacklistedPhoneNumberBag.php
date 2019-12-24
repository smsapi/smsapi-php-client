<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Blacklist\Bag;

/**
 * @api
 */
class DeleteBlacklistedPhoneNumberBag
{
    /** @var string */
    public $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}
