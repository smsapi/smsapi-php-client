<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Contacts\Groups\Permissions;

use Smsapi\Client\Feature\Contacts\Groups\Permissions\Data\GroupPermissionFactory;
use Smsapi\Client\Infrastructure\RequestExecutor\RestRequestExecutor;
use Smsapi\Client\Feature\Contacts\Groups\Permissions\Bag\CreateGroupPermissionBag;
use Smsapi\Client\Feature\Contacts\Groups\Permissions\Bag\DeleteGroupPermissionBag;
use Smsapi\Client\Feature\Contacts\Groups\Permissions\Bag\FindGroupPermissionBag;
use Smsapi\Client\Feature\Contacts\Groups\Permissions\Bag\FindGroupPermissionsBag;
use Smsapi\Client\Feature\Contacts\Groups\Permissions\Bag\UpdateGroupPermissionBag;
use Smsapi\Client\Feature\Contacts\Groups\Permissions\Data\GroupPermission;
use Smsapi\Client\SmsapiClientException;

/**
 * @internal
 */
class ContactsGroupsPermissionsHttpFeature implements ContactsGroupsPermissionsFeature
{

    /** @var RestRequestExecutor */
    private $restRequestExecutor;

    /** @var GroupPermissionFactory */
    private $groupPermissionFactory;

    public function __construct(
        RestRequestExecutor $restRequestExecutor,
        GroupPermissionFactory $groupPermissionFactory
    ) {
        $this->restRequestExecutor = $restRequestExecutor;
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
        $result = $this->restRequestExecutor->create(
            'contacts/groups/' . $groupId . '/permissions/' . $username,
            (array)$createGroupPermissionBag
        );
        return $this->groupPermissionFactory->createFromObject($result);
    }

    /**
     * @param DeleteGroupPermissionBag $deleteGroupPermissionBag
     * @throws SmsapiClientException
     */
    public function deletePermission(DeleteGroupPermissionBag $deleteGroupPermissionBag)
    {
        $this->restRequestExecutor->delete(
            sprintf(
                'contacts/groups/%s/permissions/%s',
                $deleteGroupPermissionBag->groupId,
                $deleteGroupPermissionBag->username
            ),
            []
        );
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
        $result = $this->restRequestExecutor->update(
            sprintf('contacts/groups/%s/permissions/%s', $groupId, $username),
            (array)$updateGroupPermissionBag
        );
        return $this->groupPermissionFactory->createFromObject($result);
    }

    /**
     * @param FindGroupPermissionBag $findGroupPermissionBag
     * @return GroupPermission
     * @throws SmsapiClientException
     */
    public function findPermission(FindGroupPermissionBag $findGroupPermissionBag): GroupPermission
    {
        $result = $this->restRequestExecutor->read(
            sprintf(
                'contacts/groups/%s/permissions/%s',
                $findGroupPermissionBag->groupId,
                $findGroupPermissionBag->username
            ),
            []
        );
        return $this->groupPermissionFactory->createFromObject($result);
    }

    /**
     * @param FindGroupPermissionsBag $findGroupPermissionsBag
     * @return GroupPermission[]
     * @throws SmsapiClientException
     */
    public function findPermissions(FindGroupPermissionsBag $findGroupPermissionsBag): array
    {
        $result = $this->restRequestExecutor->read(
            'contacts/groups/' . $findGroupPermissionsBag->groupId . '/permissions',
            []
        );
        return array_map(
            [$this->groupPermissionFactory, 'createFromObject'],
            $result->collection
        );
    }
}
