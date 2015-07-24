<?php

namespace SMSApi\Api\Action\Contacts;

use SMSApi\Api\Response\Contacts\DeleteResponse;

/**
 * @method DeleteResponse execute()
 */
final class ContactDeleteMultiple extends ContactCount
{
    public function getMethod()
    {
        return self::METHOD_DELETE;
    }

    protected function response($data)
    {
        return new DeleteResponse;
    }
}
