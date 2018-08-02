<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Contacts\Data;

use DateTimeInterface;
use Smsapi\Client\Feature\Contacts\Groups\Permissions\Data\GroupPermission;

/**
 * @api
 */
class ContactGroup
{

    /** @var string */
    public $id;

    /** @var string */
    public $name;

    /** @var DateTimeInterface */
    public $dateCreated;

    /** @var DateTimeInterface */
    public $dateUpdated;

    /** @var string */
    public $description;

    /** @var string */
    public $createdBy;

    /** @var string|null */
    public $idx;

    /** @var DateTimeInterface|null */
    public $contactExpireAfter;

    /** @var int|null */
    public $contactsCount;

    /** @var GroupPermission[]|null */
    public $permissions;
}
