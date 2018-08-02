<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Contacts\Data;

use DateTime;
use Smsapi\Client\Feature\Contacts\Groups\Permissions\Data\GroupPermissionFactory;
use stdClass;

/**
 * @internal
 */
class ContactGroupFactory
{
    private $groupPermissionFactory;

    public function __construct(GroupPermissionFactory $groupPermissionFactory)
    {
        $this->groupPermissionFactory = $groupPermissionFactory;
    }

    public function createFromObjectWithoutPermissions(stdClass $object): ContactGroup
    {
        $contactGroup = new ContactGroup();
        $contactGroup->id = $object->id;
        $contactGroup->name = $object->name;
        $contactGroup->dateCreated = new DateTime($object->date_created);
        $contactGroup->dateUpdated = new DateTime($object->date_updated);
        $contactGroup->description = $object->description;
        $contactGroup->idx = $object->idx;
        $contactGroup->createdBy = $object->created_by;
        $contactGroup->contactsCount = $object->contacts_count;

        if ($object->contact_expire_after) {
            $contactGroup->contactExpireAfter = new DateTime($object->contact_expire_after);
        }

        return $contactGroup;
    }

    public function createFromObjectWithPermissions(stdClass $object): ContactGroup
    {
        $contactGroup = $this->createFromObjectWithoutPermissions($object);
        $contactGroup->permissions = array_map(
            [$this->groupPermissionFactory, 'createFromObject'],
            $object->permissions
        );

        return $contactGroup;
    }
}
