<?php

namespace SMSApi\Api\Action\Contacts;

use SMSApi\Api\Response\Contacts\FieldsResponse;

/**
 * @method FieldsResponse execute()
 */
final class FieldList extends ContactsAction
{
    public function getMethod()
    {
        return self::METHOD_GET;
    }

    protected function getResource()
    {
        return '/contacts/fields';
    }

    protected function response($data)
    {
        return FieldsResponse::fromJsonString($data);
    }
}
