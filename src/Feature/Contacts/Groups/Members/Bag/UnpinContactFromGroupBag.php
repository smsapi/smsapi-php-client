<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Contacts\Groups\Members\Bag;

/**
 * @api
 */
#[\AllowDynamicProperties]
class UnpinContactFromGroupBag
{

    /** @var string */
    public $contactId;

    /** @var string */
    public $groupId;

    public function __construct(string $contactId, string $groupId)
    {
        $this->contactId = $contactId;
        $this->groupId = $groupId;
    }
}
