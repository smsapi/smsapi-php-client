<?php

namespace SMSApi\Api\Response\Contacts;

final class FieldsResponse extends ListResponse
{
    protected function createItem(array $item)
    {
        return new FieldResponse($item);
    }
}
