<?php

namespace SMSApi\Api\Action\Contacts;

use SMSApi\Api\Response\Contacts\DeleteResponse;
use SMSApi\Client;
use SMSApi\Proxy\Proxy;

/**
 * @method DeleteResponse execute()
 */
final class ContactGroupDelete extends ContactsAction
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
        return self::METHOD_DELETE;
    }

    protected function response($data)
    {
        return new DeleteResponse;
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
}
