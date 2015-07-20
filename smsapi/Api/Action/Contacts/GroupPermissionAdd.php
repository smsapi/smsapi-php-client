<?php

namespace SMSApi\Api\Action\Contacts;

use SMSApi\Api\Response\Contacts\PermissionResponse;
use SMSApi\Client;
use SMSApi\Proxy\Proxy;

/**
 * @method PermissionResponse execute()
 */
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
        return strtr('/contacts/groups/:groupId/permissions', array(':groupId' => $this->groupId));
    }

    public function enableRead()
    {
        $this->params[PermissionResponse::FIELD_READ] = true;

        return $this;
    }

    public function disableRead()
    {
        $this->params[PermissionResponse::FIELD_READ] = false;

        return $this;
    }

    public function enableWrite()
    {
        $this->params[PermissionResponse::FIELD_WRITE] = true;

        return $this;
    }

    public function disableWrite()
    {
        $this->params[PermissionResponse::FIELD_WRITE] = false;

        return $this;
    }

    public function enableSend()
    {
        $this->params[PermissionResponse::FIELD_SEND] = true;

        return $this;
    }

    public function disableSend()
    {
        $this->params[PermissionResponse::FIELD_SEND] = false;

        return $this;
    }
}
