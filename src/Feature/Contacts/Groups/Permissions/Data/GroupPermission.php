<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Contacts\Groups\Permissions\Data;

/**
 * @api
 */
class GroupPermission
{

    /** @var string */
    public $username;

    /** @var string */
    public $groupId;

    /** @var bool */
    public $write;

    /** @var bool */
    public $read;

    /** @var bool */
    public $send;
}
