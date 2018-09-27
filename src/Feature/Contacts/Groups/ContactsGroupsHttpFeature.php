<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Contacts\Groups;

use Fig\Http\Message\RequestMethodInterface;
use Smsapi\Client\Feature\Data\DataFactoryProvider;
use Smsapi\Client\Infrastructure\Request\RequestBuilderFactory;
use Smsapi\Client\Infrastructure\Request\RestRequestBuilderFactory;
use Smsapi\Client\Infrastructure\RequestExecutor\RequestExecutor;
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
use Smsapi\Client\Infrastructure\RequestExecutor\RestRequestExecutor;

/**
 * @internal
 */
class ContactsGroupsHttpFeature implements ContactsGroupsFeature
{
    /**
     * @var DataFactoryProvider
     */
    private $dataFactoryProvider;

    /**
     * @var RestRequestExecutor
     */
    private $requestExecutor;

    /**
     * @var RestRequestBuilderFactory
     */
    private $requestBuilderFactory;

    public function __construct(
        RestRequestExecutor $restRequestExecutor,
        RestRequestBuilderFactory $requestBuilderFactory,
        DataFactoryProvider $dataFactoryProvider
    ) {
        $this->requestExecutor = $restRequestExecutor;
        $this->dataFactoryProvider = $dataFactoryProvider;
        $this->requestBuilderFactory = $requestBuilderFactory;
    }

    public function createGroup(CreateGroupBag $createGroupBag): ContactGroup
    {
        $builder = $this->requestBuilderFactory->create();

        $request = $builder
            ->withMethod(RequestMethodInterface::METHOD_POST)
            ->withPath('contacts/groups')
            ->withBuiltInParameters((array) $createGroupBag)
            ->get();

        $result = $this->requestExecutor->execute($request);

        return $this->dataFactoryProvider
            ->provideContactGroupFactory()
            ->createFromObjectWithPermissions($result);
    }

    public function deleteGroup(DeleteGroupBag $deleteGroupBag)
    {
        $groupId = $deleteGroupBag->groupId;
        unset($deleteGroupBag->groupId);

        $builder = $this->requestBuilderFactory->create();

        $request = $builder
            ->withMethod(RequestMethodInterface::METHOD_DELETE)
            ->withPath(sprintf('contacts/groups/%s', $groupId))
            ->withBuiltInParameters((array) $deleteGroupBag)
            ->get();

        $this->requestExecutor->execute($request);
    }

    public function findGroup(FindGroupBag $findGroupBag): ContactGroup
    {
        $builder = $this->requestBuilderFactory->create();

        $request = $builder
            ->withMethod(RequestMethodInterface::METHOD_GET)
            ->withPath(sprintf('contacts/groups/%s', $findGroupBag->groupId))
            ->get();

        $result = $this->requestExecutor->execute($request);

        return $this->dataFactoryProvider
            ->provideContactGroupFactory()
            ->createFromObjectWithPermissions($result);
    }

    public function updateGroup(UpdateGroupBag $updateGroupBag): ContactGroup
    {
        $groupId = $updateGroupBag->groupId;

        unset($updateGroupBag->groupId);

        $builder = $this->requestBuilderFactory->create();

        $request = $builder
            ->withMethod(RequestMethodInterface::METHOD_POST)
            ->withPath(sprintf('contacts/groups/%s', $groupId))
            ->withBuiltInParameters((array) $updateGroupBag)
            ->get();

        $result = $this->requestExecutor->execute($request);

        return $this->dataFactoryProvider
            ->provideContactGroupFactory()
            ->createFromObjectWithPermissions($result);
    }

    public function assignContactToGroup(AssignContactToGroupBag $assignContactToGroupBag): array
    {
        $builder = $this->requestBuilderFactory->create();

        $request = $builder
            ->withMethod(RequestMethodInterface::METHOD_PUT)
            ->withPath(sprintf('contacts/%s/groups/%s', $assignContactToGroupBag->contactId, $assignContactToGroupBag->groupId))
            ->get();

        $result = $this->requestExecutor->execute($request);

        return array_map(
            [$this->dataFactoryProvider->provideContactGroupFactory(), 'createFromObjectWithPermissions'],
            $result->collection
        );
    }

    public function findContactGroup(FindContactGroupBag $findContactGroupBag): ContactGroup
    {
        $builder = $this->requestBuilderFactory->create();

        $request = $builder
            ->withMethod(RequestMethodInterface::METHOD_POST)
            ->withPath(sprintf('contacts/%s/groups/%s', $findContactGroupBag->contactId, $findContactGroupBag->groupId))
            ->get();

        $result = $this->requestExecutor->execute($request);

        return $this->dataFactoryProvider
            ->provideContactGroupFactory()
            ->createFromObjectWithPermissions($result);
    }

    public function findContactGroups(FindContactGroupsBag $findContactGroupsBag): array
    {
        $builder = $this->requestBuilderFactory->create();

        $request = $builder
            ->withMethod(RequestMethodInterface::METHOD_POST)
            ->withPath(sprintf('contacts/%s/groups', $findContactGroupsBag->contactId))
            ->get();

        $result = $this->requestExecutor->execute($request);

        return array_map(
            [$this->dataFactoryProvider->provideContactGroupFactory(), 'createFromObjectWithPermissions'],
            $result->collection
        );
    }

    public function unpinContactFromGroup(UnpinContactFromGroupBag $unpinContactFromGroupBag)
    {
        $builder = $this->requestBuilderFactory->create();

        $request = $builder
            ->withMethod(RequestMethodInterface::METHOD_DELETE)
            ->withPath(sprintf('contacts/%s/groups/%s', $unpinContactFromGroupBag->contactId, $unpinContactFromGroupBag->groupId))
            ->get();

        $this->requestExecutor->execute($request);
    }

    public function membersFeature(): ContactsGroupsMembersFeature
    {
        return new ContactsGroupsMembersHttpFeature(
            $this->requestExecutor,
            $this->requestBuilderFactory,
            $this->dataFactoryProvider->provideContactFactory()
        );
    }

    public function permissionsFeature(): ContactsGroupsPermissionsFeature
    {
        return new ContactsGroupsPermissionsHttpFeature(
            $this->requestExecutor,
            $this->requestBuilderFactory,
            $this->dataFactoryProvider->provideGroupPermissionFactory()
        );
    }
}
