<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Contacts\Groups\Permissions;

use Smsapi\Client\Feature\Contacts\Groups\Permissions\Bag\CreateGroupPermissionBag;
use Smsapi\Client\Feature\Contacts\Groups\Permissions\Bag\DeleteGroupPermissionBag;
use Smsapi\Client\Feature\Contacts\Groups\Permissions\Bag\FindGroupPermissionBag;
use Smsapi\Client\Feature\Contacts\Groups\Permissions\Bag\FindGroupPermissionsBag;
use Smsapi\Client\Feature\Contacts\Groups\Permissions\Bag\UpdateGroupPermissionBag;
use Smsapi\Client\Feature\Contacts\Groups\Permissions\Data\GroupPermission;

/**
 * @api
 */
interface ContactsGroupsPermissionsFeature
{

    public function createPermission(CreateGroupPermissionBag $createGroupPermissionBag): GroupPermission;

    public function deletePermission(DeleteGroupPermissionBag $deleteGroupPermissionBag);

    public function updatePermission(UpdateGroupPermissionBag $updateGroupPermissionBag): GroupPermission;

    public function findPermission(FindGroupPermissionBag $findGroupPermissionBag): GroupPermission;

    public function findPermissions(FindGroupPermissionsBag $findGroupPermissionsBag): array;
}
