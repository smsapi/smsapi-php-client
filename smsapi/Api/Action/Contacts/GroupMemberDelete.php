<?php

namespace SMSApi\Api\Action\Contacts;

use SMSApi\Api\Response\RawResponse;

final class GroupMemberDelete extends GroupMemberAdd
{
    public function getMethod()
    {
        return self::METHOD_DELETE;
    }

    protected function response($data)
    {
        return new RawResponse($data);
    }
}
