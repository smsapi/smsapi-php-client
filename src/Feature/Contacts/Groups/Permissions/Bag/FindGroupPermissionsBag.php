<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Contacts\Groups\Permissions\Bag;

/**
 * @api
 */
#[\AllowDynamicProperties]
class FindGroupPermissionsBag
{

    /** @var string */
    public $groupId;

    public function __construct(string $groupId)
    {
        $this->groupId = $groupId;
    }
}
