<?php

namespace SMSApi\Api\Response\Contacts;

/**
 * @method GroupResponse[] getCollection()
 */
final class GroupsResponse extends ListResponse
{
    protected function createItem(array $item)
    {
        return new GroupResponse($item);
    }
}
