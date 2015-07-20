<?php

namespace SMSApi\Api\Action\Contacts;

final class GroupMemberGet extends GroupMemberAdd
{
    public function getMethod()
    {
        return self::METHOD_GET;
    }
}
