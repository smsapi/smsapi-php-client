<?php

namespace SMSApi\Api\Action\Contacts;

use SMSApi\Api\Response\Contacts\ContactResponse;
use SMSApi\Client;
use SMSApi\Proxy\Proxy;

/**
 * @method ContactResponse execute()
 */
final class ContactGet extends ContactsAction
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

    public function getResource()
    {
        return strtr('/contacts/:contactId', array(':contactId' => $this->contactId));
    }

    protected function response($data)
    {
        return ContactResponse::fromJsonString($data);
    }
}
