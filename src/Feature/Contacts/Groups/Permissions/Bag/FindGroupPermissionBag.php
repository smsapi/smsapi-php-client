<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Contacts\Groups\Permissions\Bag;

/**
 * @api
 */
#[\AllowDynamicProperties]
class FindGroupPermissionBag
{

    /** @var string */
    public $groupId;

    /** @var string */
    public $username;

    public function __construct(string $groupId, string $username)
    {
        $this->groupId = $groupId;
        $this->username = $username;
    }
}
