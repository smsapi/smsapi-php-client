<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Contacts\Groups\Permissions\Data;

use stdClass;

/**
 * @internal
 */
class GroupPermissionFactory
{
    public function createFromObject(stdClass $object): GroupPermission
    {
        $permission = new GroupPermission();
        $permission->username = $object->username;
        $permission->groupId = $object->group_id;
        $permission->write = $object->write;
        $permission->read = $object->read;
        $permission->send = $object->send;

        return $permission;
    }
}
