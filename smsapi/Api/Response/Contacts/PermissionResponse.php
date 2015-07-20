<?php

namespace SMSApi\Api\Response\Contacts;

final class PermissionResponse extends AbstractContactsResponse
{
    const FIELD_GROUP_ID = 'group_id';
    const FIELD_READ = 'read';
    const FIELD_WRITE = 'write';
    const FIELD_SEND = 'send';
    const FIELD_USERNAME = 'username';

    private $groupId;
    private $read;
    private $write;
    private $send;
    private $username;

    public function __construct(array $data)
    {
        $this->groupId = $data[self::FIELD_GROUP_ID];
        $this->read = $data[self::FIELD_READ];
        $this->write = $data[self::FIELD_WRITE];
        $this->send = $data[self::FIELD_SEND];
        $this->username = $data[self::FIELD_USERNAME];
    }

    public function getGroupId()
    {
        return $this->groupId;
    }

    public function getRead()
    {
        return $this->read;
    }

    public function getWrite()
    {
        return $this->write;
    }

    public function getSend()
    {
        return $this->send;
    }

    public function getUsername()
    {
        return $this->username;
    }
}
