<?php

namespace SMSApi\Api\Response\Contacts;

/**
 * @method PermissionResponse[] getCollection()
 */
final class PermissionsResponse extends ListResponse
{
    protected function createItem(array $item)
    {
        return new PermissionResponse($item);
    }
}
