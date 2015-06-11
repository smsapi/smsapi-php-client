<?php

namespace SMSApi\Api\Action\Contacts;

use SMSApi\Api\Response\RawResponse;
use SMSApi\Client;
use SMSApi\Proxy\Proxy;

final class GroupPermissionDelete extends ContactsAction
{
    private $groupId;
    private $username;

    public function __construct($groupId, $username, Client $client, Proxy $proxy)
    {
        parent::__construct($client, $proxy);

        $this->groupId = $groupId;
        $this->username = $username;
    }

    public function getMethod()
    {
        return self::METHOD_DELETE;
    }

    protected function response($data)
    {
        return new RawResponse($data);
    }

    protected function getResource()
    {
        return strtr(
            '/contacts/groups/:groupId/permission/:username',
            [
                ':groupId' => $this->groupId,
                ':username' => $this->username,
            ]
        );
    }
}
