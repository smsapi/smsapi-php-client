<?php

namespace SMSApi\Api\Action\Contacts;

use SMSApi\Api\Response\Contacts\GroupsResponse;
use SMSApi\Client;
use SMSApi\Proxy\Proxy;

/**
 * @method GroupsResponse execute()
 */
final class ContactGroupList extends ContactsAction
{
    private $contactId;

    public function __construct($contactId, Client $client, Proxy $proxy)
    {
        parent::__construct($client, $proxy);

        $this->contactId = $contactId;
    }

    public function getMethod()
    {
        return self::METHOD_GET;
    }

    protected function response($data)
    {
        return GroupsResponse::fromJsonString($data);
    }

    protected function getResource()
    {
        return strtr('/contacts/:contactId/groups', array(':contactId' => $this->contactId));
    }
}
