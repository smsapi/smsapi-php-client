<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Contacts\Groups;

use Smsapi\Client\Feature\Data\DataFactoryProvider;
use Smsapi\Client\Infrastructure\RequestExecutor\RestRequestExecutor;
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
use Smsapi\Client\Feature\Contacts\Groups\Members\ContactsGroupsMembersHttpFeature;
use Smsapi\Client\Feature\Contacts\Groups\Permissions\ContactsGroupsPermissionsFeature;
use Smsapi\Client\Feature\Contacts\Groups\Permissions\ContactsGroupsPermissionsHttpFeature;

/**
 * @internal
 */
class ContactsGroupsHttpFeature implements ContactsGroupsFeature
{
    private $restRequestExecutor;
    private $dataFactoryProvider;

    public function __construct(RestRequestExecutor $restRequestExecutor, DataFactoryProvider $dataFactoryProvider)
    {
        $this->restRequestExecutor = $restRequestExecutor;
        $this->dataFactoryProvider = $dataFactoryProvider;
    }

    public function createGroup(CreateGroupBag $createGroupBag): ContactGroup
    {
        $result = $this->restRequestExecutor->create('contacts/groups', (array)$createGroupBag);

        return $this->dataFactoryProvider
            ->provideContactGroupFactory()
            ->createFromObjectWithPermissions($result);
    }

    public function deleteGroup(DeleteGroupBag $deleteGroupBag)
    {
        $groupId = $deleteGroupBag->groupId;
        unset($deleteGroupBag->groupId);
        $this->restRequestExecutor->delete('contacts/groups/' . $groupId, (array)$deleteGroupBag);
    }

    public function findGroup(FindGroupBag $findGroupBag): ContactGroup
    {
        $result = $this->restRequestExecutor->read('contacts/groups/' . $findGroupBag->groupId, []);

        return $this->dataFactoryProvider
            ->provideContactGroupFactory()
            ->createFromObjectWithPermissions($result);
    }

    public function updateGroup(UpdateGroupBag $updateGroupBag): ContactGroup
    {
        $groupId = $updateGroupBag->groupId;

        unset($updateGroupBag->groupId);

        $result = $this->restRequestExecutor->update('contacts/groups/' . $groupId, (array)$updateGroupBag);

        return $this->dataFactoryProvider
            ->provideContactGroupFactory()
            ->createFromObjectWithPermissions($result);
    }

    public function assignContactToGroup(AssignContactToGroupBag $assignContactToGroupBag): array
    {
        $result = $this->restRequestExecutor->update(
            'contacts/' . $assignContactToGroupBag->contactId . '/groups/' . $assignContactToGroupBag->groupId,
            []
        );
        return array_map(
            [$this->dataFactoryProvider->provideContactGroupFactory(), 'createFromObjectWithPermissions'],
            $result->collection
        );
    }

    public function findContactGroup(FindContactGroupBag $findContactGroupBag): ContactGroup
    {
        $result = $this->restRequestExecutor->read(
            'contacts/' . $findContactGroupBag->contactId . '/groups/' . $findContactGroupBag->groupId,
            []
        );

        return $this->dataFactoryProvider
            ->provideContactGroupFactory()
            ->createFromObjectWithPermissions($result);
    }

    public function findContactGroups(FindContactGroupsBag $findContactGroupsBag): array
    {
        $result = $this->restRequestExecutor->read(
            'contacts/' . $findContactGroupsBag->contactId . '/groups',
            []
        );
        return array_map(
            [$this->dataFactoryProvider->provideContactGroupFactory(), 'createFromObjectWithPermissions'],
            $result->collection
        );
    }

    public function unpinContactFromGroup(UnpinContactFromGroupBag $unpinContactFromGroupBag)
    {
        $this->restRequestExecutor->delete(
            'contacts/' . $unpinContactFromGroupBag->contactId . '/groups/' . $unpinContactFromGroupBag->groupId,
            []
        );
    }

    public function findGroups(): array
    {
        $result = $this->restRequestExecutor->read(
            'contacts/groups/',
            []
        );

        return array_map(
            [$this->dataFactoryProvider->provideContactGroupFactory(), 'createFromObjectWithPermissions'],
            $result->collection
        );
    }

    public function membersFeature(): ContactsGroupsMembersFeature
    {
        return new ContactsGroupsMembersHttpFeature(
            $this->restRequestExecutor,
            $this->dataFactoryProvider->provideContactFactory()
        );
    }

    public function permissionsFeature(): ContactsGroupsPermissionsFeature
    {
        return new ContactsGroupsPermissionsHttpFeature(
            $this->restRequestExecutor,
            $this->dataFactoryProvider->provideGroupPermissionFactory()
        );
    }
}
