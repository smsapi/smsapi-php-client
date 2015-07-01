<?php

namespace SMSApi\Api\Action\Contacts;

use SMSApi\Api\Response\Contacts\GroupResponse;
use SMSApi\Api\Response\Contacts\GroupsResponse;

final class GroupList extends ContactsAction
{
    public function getMethod()
    {
        return self::METHOD_GET;
    }

    public function getResource()
    {
        return '/contacts/groups';
    }

    protected function response($data)
    {
        return GroupsResponse::fromJsonString($data);
    }

    public function setIds(array $ids)
    {
        $this->params[GroupResponse::FIELD_ID] = $ids;

        return $this;
    }

    public function setNames(array $names)
    {
        $this->params[GroupResponse::FIELD_NAME] = $names;

        return $this;
    }
}
