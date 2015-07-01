<?php

namespace SMSApi\Api\Action\Contacts;

use SMSApi\Api\Response\RawResponse;
use SMSApi\Client;
use SMSApi\Proxy\Proxy;

final class ContactsDelete extends ContactsAction
{
    private $contactId;

    public function __construct($contactId, Client $client, Proxy $proxy)
    {
        parent::__construct($client, $proxy);

        $this->contactId = $contactId;
    }

    public function getMethod()
    {
        return self::METHOD_DELETE;
    }

    protected function getResource()
    {
        return strtr('/contacts/:contactId', array(':contactId' => $this->contactId));
    }

    protected function response($data)
    {
        return new RawResponse($data);
    }
}
