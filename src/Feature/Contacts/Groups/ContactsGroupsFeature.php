<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Contacts\Groups;

use Smsapi\Client\Feature\Contacts\Data\ContactGroup;
use Smsapi\Client\Feature\Contacts\Groups\Bag\AssignContactToGroupBag;
use Smsapi\Client\Feature\Contacts\Groups\Bag\CreateGroupBag;
use Smsapi\Client\Feature\Contacts\Groups\Bag\DeleteGroupBag;
use Smsapi\Client\Feature\Contacts\Groups\Bag\FindContactGroupBag;
use Smsapi\Client\Feature\Contacts\Groups\Bag\FindContactGroupsBag;
use Smsapi\Client\Feature\Contacts\Groups\Bag\FindGroupBag;
use Smsapi\Client\Feature\Contacts\Groups\Bag\UnpinContactFromGroupBag;
use Smsapi\Client\Feature\Contacts\Groups\Bag\UpdateGroupBag;
use Smsapi\Client\Feature\Contacts\Groups\Members\ContactsGroupsMembersFeature;
use Smsapi\Client\Feature\Contacts\Groups\Permissions\ContactsGroupsPermissionsFeature;

/**
 * @api
 */
interface ContactsGroupsFeature
{

    public function createGroup(CreateGroupBag $createGroupBag): ContactGroup;

    public function deleteGroup(DeleteGroupBag $deleteGroupBag);

    public function findGroup(FindGroupBag $findGroupBag): ContactGroup;

    public function updateGroup(UpdateGroupBag $updateGroupBag): ContactGroup;

    public function assignContactToGroup(AssignContactToGroupBag $assignContactToGroupBag): array;

    public function findContactGroup(FindContactGroupBag $findContactGroupBag): ContactGroup;

    public function findContactGroups(FindContactGroupsBag $findContactGroupsBag): array;

    public function unpinContactFromGroup(UnpinContactFromGroupBag $unpinContactFromGroupBag);

    public function findGroups(): array;

    public function membersFeature(): ContactsGroupsMembersFeature;

    public function permissionsFeature(): ContactsGroupsPermissionsFeature;
}
