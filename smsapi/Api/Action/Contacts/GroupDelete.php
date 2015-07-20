<?php

namespace SMSApi\Api\Action\Contacts;

use SMSApi\Api\Response\Contacts\DeleteResponse;
use SMSApi\Client;
use SMSApi\Proxy\Proxy;

/**
 * @method DeleteResponse execute()
 */
final class GroupDelete extends ContactsAction
{
    const RESOURCE = '/contacts/groups/';

    private $groupId;

    public function __construct($groupId, Client $client, Proxy $proxy)
    {
        parent::__construct($client, $proxy);

        $this->groupId = $groupId;
    }

    public function getMethod()
    {
        return self::METHOD_DELETE;
    }

    public function getResource()
    {
        return strtr('/contacts/groups/:groupId', array(':groupId' => $this->groupId));
    }

    protected function response($data)
    {
        return new DeleteResponse;
    }
}
