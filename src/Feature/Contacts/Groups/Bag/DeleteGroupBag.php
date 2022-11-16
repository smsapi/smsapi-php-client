<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Contacts\Groups\Bag;

/**
 * @api
 * @property bool $deleteContacts
 */
#[\AllowDynamicProperties]
class DeleteGroupBag
{

    /** @var string */
    public $groupId;

    public function __construct(string $groupId)
    {
        $this->groupId = $groupId;
    }
}
