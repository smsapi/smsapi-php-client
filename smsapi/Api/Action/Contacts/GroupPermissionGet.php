<?php

namespace SMSApi\Api\Action\Contacts;

use SMSApi\Api\Response\Contacts\PermissionResponse;
use SMSApi\Client;
use SMSApi\Proxy\Proxy;

/**
 * @method PermissionResponse execute()
 */
final class GroupPermissionGet extends ContactsAction
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
        return self::METHOD_GET;
    }

    protected function response($data)
    {
        return PermissionResponse::fromJsonString($data);
    }

    protected function getResource()
    {
        return strtr(
            '/contacts/groups/:groupId/permissions/:username',
            array(
                ':groupId' => $this->groupId,
                ':username' => urlencode($this->username),
            )
        );
    }
}
