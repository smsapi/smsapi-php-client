<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Contacts\Groups\Permissions;

use Fig\Http\Message\RequestMethodInterface;
use Smsapi\Client\Feature\Contacts\Groups\Permissions\Data\GroupPermissionFactory;
use Smsapi\Client\Infrastructure\Request\RequestBuilderFactory;
use Smsapi\Client\Infrastructure\Request\RestRequestBuilderFactory;
use Smsapi\Client\Infrastructure\RequestExecutor\RequestExecutor;
use Smsapi\Client\Feature\Contacts\Groups\Permissions\Bag\CreateGroupPermissionBag;
use Smsapi\Client\Feature\Contacts\Groups\Permissions\Bag\DeleteGroupPermissionBag;
use Smsapi\Client\Feature\Contacts\Groups\Permissions\Bag\FindGroupPermissionBag;
use Smsapi\Client\Feature\Contacts\Groups\Permissions\Bag\FindGroupPermissionsBag;
use Smsapi\Client\Feature\Contacts\Groups\Permissions\Bag\UpdateGroupPermissionBag;
use Smsapi\Client\Feature\Contacts\Groups\Permissions\Data\GroupPermission;
use Smsapi\Client\Infrastructure\RequestExecutor\RestRequestExecutor;
use Smsapi\Client\SmsapiClientException;

/**
 * @internal
 */
class ContactsGroupsPermissionsHttpFeature implements ContactsGroupsPermissionsFeature
{
    /**
     * @var RestRequestExecutor
     */
    private $requestExecutor;

    /**
     * @var RestRequestBuilderFactory
     */
    private $requestBuilderFactory;

    /**
     * @var GroupPermissionFactory
     */
    private $groupPermissionFactory;

    public function __construct(
        RestRequestExecutor $restRequestExecutor,
        RestRequestBuilderFactory $requestBuilderFactory,
        GroupPermissionFactory $groupPermissionFactory
    ) {
        $this->requestExecutor = $restRequestExecutor;
        $this->requestBuilderFactory = $requestBuilderFactory;
        $this->groupPermissionFactory = $groupPermissionFactory;
    }

    /**
     * @param CreateGroupPermissionBag $createGroupPermissionBag
     * @return GroupPermission
     * @throws SmsapiClientException
     */
    public function createPermission(CreateGroupPermissionBag $createGroupPermissionBag): GroupPermission
    {
        $groupId = $createGroupPermissionBag->groupId;
        $username = $createGroupPermissionBag->username;
        unset($createGroupPermissionBag->groupId);
        unset($createGroupPermissionBag->username);

        $builder = $this->requestBuilderFactory->create();

        $request = $builder
            ->withMethod(RequestMethodInterface::METHOD_POST)
            ->withPath(sprintf('contacts/groups/%s/permissions/%s', $groupId, $username))
            ->withBuiltInParameters((array) $createGroupPermissionBag)
            ->get();

        $result = $this->requestExecutor->execute($request);

        return $this->groupPermissionFactory->createFromObject($result);
    }

    /**
     * @param DeleteGroupPermissionBag $deleteGroupPermissionBag
     * @throws SmsapiClientException
     */
    public function deletePermission(DeleteGroupPermissionBag $deleteGroupPermissionBag)
    {
        $builder = $this->requestBuilderFactory->create();

        $request = $builder
            ->withMethod(RequestMethodInterface::METHOD_DELETE)
            ->withPath(sprintf(
                'contacts/groups/%s/permissions/%s',
                $deleteGroupPermissionBag->groupId,
                $deleteGroupPermissionBag->username
            ))
            ->get();

        $this->requestExecutor->execute($request);
    }

    /**
     * @param UpdateGroupPermissionBag $updateGroupPermissionBag
     * @return GroupPermission
     * @throws SmsapiClientException
     */
    public function updatePermission(UpdateGroupPermissionBag $updateGroupPermissionBag): GroupPermission
    {
        $groupId = $updateGroupPermissionBag->groupId;
        $username = $updateGroupPermissionBag->username;
        unset($updateGroupPermissionBag->groupId);
        unset($updateGroupPermissionBag->username);

        $builder = $this->requestBuilderFactory->create();

        $request = $builder
            ->withMethod(RequestMethodInterface::METHOD_PUT)
            ->withPath(sprintf(
                'contacts/groups/%s/permissions/%s',
                $groupId,
                $username
            ))
            ->withBuiltInParameters((array) $updateGroupPermissionBag)
            ->get();

        $result = $this->requestExecutor->execute($request);

        return $this->groupPermissionFactory->createFromObject($result);
    }

    /**
     * @param FindGroupPermissionBag $findGroupPermissionBag
     * @return GroupPermission
     * @throws SmsapiClientException
     */
    public function findPermission(FindGroupPermissionBag $findGroupPermissionBag): GroupPermission
    {
        $builder = $this->requestBuilderFactory->create();

        $request = $builder
            ->withMethod(RequestMethodInterface::METHOD_GET)
            ->withPath(sprintf(
                'contacts/groups/%s/permissions/%s',
                $findGroupPermissionBag->groupId,
                $findGroupPermissionBag->username
            ))
            ->get();

        $result = $this->requestExecutor->execute($request);

        return $this->groupPermissionFactory->createFromObject($result);
    }

    /**
     * @param FindGroupPermissionsBag $findGroupPermissionsBag
     * @return GroupPermission[]
     * @throws SmsapiClientException
     */
    public function findPermissions(FindGroupPermissionsBag $findGroupPermissionsBag): array
    {

        $builder = $this->requestBuilderFactory->create();

        $request = $builder
            ->withMethod(RequestMethodInterface::METHOD_PUT)
            ->withPath(sprintf(
                'contacts/groups/%s/permissions',
                $findGroupPermissionsBag->groupId
            ))
            ->get();

        $result = $this->requestExecutor->execute($request);

        return array_map(
            [$this->groupPermissionFactory, 'createFromObject'],
            $result->collection
        );
    }
}
