<?php

namespace SMSApi\Api\Action\Contacts;

use SMSApi\Api\Response\Contacts\PermissionResponse;
use SMSApi\Client;
use SMSApi\Proxy\Proxy;

final class GroupPermissionAdd extends ContactsAction
{
    private $groupId;

    public function __construct($groupId, $username, Client $client, Proxy $proxy)
    {
        parent::__construct($client, $proxy);

        $this->groupId = $groupId;
        $this->params[PermissionResponse::FIELD_USERNAME] = $username;
    }

    public function getMethod()
    {
        return self::METHOD_POST;
    }

    protected function response($data)
    {
        return PermissionResponse::fromJsonString($data);
    }

    protected function getResource()
    {
        return strtr('/contacts/groups/:groupId/permission', [':groupId' => $this->groupId]);
    }

    public function enableRead()
    {
        $this->params[PermissionResponse::FIELD_READ] = true;
    }

    public function disableRead()
    {
        $this->params[PermissionResponse::FIELD_READ] = false;
    }

    public function enableWrite()
    {
        $this->params[PermissionResponse::FIELD_WRITE] = true;
    }

    public function disableWrite()
    {
        $this->params[PermissionResponse::FIELD_WRITE] = false;
    }

    public function enableSend()
    {
        $this->params[PermissionResponse::FIELD_SEND] = true;
    }

    public function disableSend()
    {
        $this->params[PermissionResponse::FIELD_SEND] = false;
    }
}
