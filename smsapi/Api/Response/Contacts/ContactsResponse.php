<?php

namespace SMSApi\Api\Response\Contacts;

final class ContactsResponse extends ListResponse
{
    protected function createItem(array $item)
    {
        return new ContactResponse($item);
    }
}
