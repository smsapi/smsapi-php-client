<?php

namespace SMSApi\Api\Response\Contacts;

/**
 * @method ContactResponse[] getCollection()
 */
final class ContactsResponse extends ListResponse
{
    protected function createItem(array $item)
    {
        return new ContactResponse($item);
    }
}
