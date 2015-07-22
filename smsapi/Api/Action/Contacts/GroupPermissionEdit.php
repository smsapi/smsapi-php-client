<?php

namespace SMSApi\Api\Action\Contacts;

use SMSApi\Api\Response\Contacts\PermissionResponse;
use SMSApi\Client;
use SMSApi\Proxy\Proxy;

/**
 * @method PermissionResponse execute()
 */
final class GroupPermissionEdit extends ContactsAction
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
        return self::METHOD_PUT;
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
                ':username' => $this->username,
            )
        );
    }

    public function enableRead()
    {
        $this->setParamValue(PermissionResponse::FIELD_READ, true);

        return $this;
    }

    public function disableRead()
    {
        $this->setParamValue(PermissionResponse::FIELD_READ, false);

        return $this;
    }

    public function enableWrite()
    {
        $this->setParamValue(PermissionResponse::FIELD_WRITE, true);

        return $this;
    }

    public function disableWrite()
    {
        $this->setParamValue(PermissionResponse::FIELD_WRITE, false);

        return $this;
    }

    public function enableSend()
    {
        $this->setParamValue(PermissionResponse::FIELD_SEND, true);

        return $this;
    }

    public function disableSend()
    {
        $this->setParamValue(PermissionResponse::FIELD_SEND, false);

        return $this;
    }
}
