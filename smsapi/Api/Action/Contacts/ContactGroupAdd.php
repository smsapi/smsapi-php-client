<?php

namespace SMSApi\Api\Action\Contacts;

use SMSApi\Api\Response\Contacts\GroupResponse;
use SMSApi\Client;
use SMSApi\Proxy\Proxy;

final class ContactsGroupAdd extends ContactsAction
{
    private $contactId;
    private $groupId;

    public function __construct($contactId, $groupId, Client $client, Proxy $proxy)
    {
        parent::__construct($client, $proxy);

        $this->contactId = $contactId;
        $this->groupId = $groupId;
    }

    public function getMethod()
    {
        return self::METHOD_POST;
    }

    protected function getResource()
    {
        return strtr(
            '/contacts/:contactId/groups/:groupId',
            [
                ':contactId' => $this->contactId,
                ':groupId' => $this->groupId,
            ]
        );
    }

    protected function response($data)
    {
        return GroupResponse::fromJsonString($data);
    }
}
