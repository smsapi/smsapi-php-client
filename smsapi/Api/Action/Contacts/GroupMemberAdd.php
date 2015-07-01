<?php

namespace SMSApi\Api\Action\Contacts;

use SMSApi\Api\Response\Contacts\ContactResponse;
use SMSApi\Client;
use SMSApi\Proxy\Proxy;

class GroupMemberAdd extends ContactsAction
{
    private $groupId;
    private $contactId;

    public function __construct($groupId, $contactId, Client $client, Proxy $proxy)
    {
        parent::__construct($client, $proxy);

        $this->groupId = $groupId;
        $this->contactId = $contactId;
    }

    public function getMethod()
    {
        return self::METHOD_POST;
    }

    protected function response($data)
    {
        return ContactResponse::fromJsonString($data);
    }

    protected function getResource()
    {
        return '/contacts/groups/:groupId/members/:contactId';
    }
}
