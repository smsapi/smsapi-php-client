<?php

namespace SMSApi\Api\Action\Contacts;

use SMSApi\Api\Response\Contacts\DeleteResponse;
use SMSApi\Client;
use SMSApi\Proxy\Proxy;

/**
 * @method DeleteResponse execute()
 */
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
        return new DeleteResponse;
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
