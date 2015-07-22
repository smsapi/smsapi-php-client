<?php

namespace SMSApi\Api\Action\Contacts;

use SMSApi\Api\Response\Contacts\GroupResponse;
use SMSApi\Client;
use SMSApi\Proxy\Proxy;

/**
 * @method GroupResponse execute()
 */
final class GroupEdit extends ContactsAction
{
    private $groupId;

    public function __construct($groupId, Client $client, Proxy $proxy)
    {
        parent::__construct($client, $proxy);

        $this->groupId = $groupId;
    }

    public function getMethod()
    {
        return self::METHOD_PUT;
    }

    public function getResource()
    {
        return strtr('/contacts/groups/:groupId', array(':groupId' => $this->groupId));
    }

    protected function response($data)
    {
        return GroupResponse::fromJsonString($data);
    }

    public function setName($name)
    {
        $this->setParamValue(GroupResponse::FIELD_NAME, $name);

        return $this;
    }

    public function setDescription($description)
    {
        $this->setParamValue(GroupResponse::FIELD_DESCRIPTION, $description);

        return $this;
    }

    public function setIdx($idx)
    {
        $this->setParamValue(GroupResponse::FIELD_IDX, $idx);

        return $this;
    }
}
