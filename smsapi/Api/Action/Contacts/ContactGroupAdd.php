<?php

namespace SMSApi\Api\Action\Contacts;

use SMSApi\Api\Response\Contacts\GroupsResponse;
use SMSApi\Client;
use SMSApi\Proxy\Proxy;

/**
 * @method GroupsResponse execute()
 */
final class ContactGroupAdd extends ContactsAction
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
        return self::METHOD_PUT;
    }

    protected function getResource()
    {
        return strtr(
            '/contacts/:contactId/groups/:groupId',
            array(
                ':contactId' => $this->contactId,
                ':groupId' => $this->groupId,
            )
        );
    }

    protected function response($data)
    {
        return GroupsResponse::fromJsonString($data);
    }
}
