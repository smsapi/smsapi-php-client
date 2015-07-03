<?php

namespace SMSApi\Api\Action\Contacts;

use SMSApi\Api\Response\Contacts\PermissionsResponse;
use SMSApi\Client;
use SMSApi\Proxy\Proxy;

/**
 * @method PermissionsResponse execute()
 */
final class GroupPermissionList extends ContactsAction
{
    private $groupId;

    public function __construct($groupId, Client $client, Proxy $proxy)
    {
        parent::__construct($client, $proxy);

        $this->groupId = $groupId;
    }

    public function getMethod()
    {
        return self::METHOD_GET;
    }

    protected function response($data)
    {
        return PermissionsResponse::fromJsonString($data);
    }

    protected function getResource()
    {
        return strtr('/contacts/groups/:groupId/permissions', array(':groupId' => $this->groupId));
    }
}
