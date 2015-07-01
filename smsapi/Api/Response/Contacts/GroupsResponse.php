<?php

namespace SMSApi\Api\Response\Contacts;

final class GroupsResponse extends ListResponse
{
    protected function createItem(array $item)
    {
        return new GroupResponse($item);
    }
}
