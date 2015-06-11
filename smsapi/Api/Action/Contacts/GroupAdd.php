<?php

namespace SMSApi\Api\Action\Contacts;

use SMSApi\Api\Response\Contacts\GroupResponse;
use SMSApi\Client;
use SMSApi\Proxy\Proxy;

final class GroupAdd extends ContactsAction
{
    const RESOURCE = '/contacts/groups';

    public function __construct($name, Client $client, Proxy $proxy)
    {
        parent::__construct($client, $proxy);

        $this->params['name'] = $name;
    }

    public function getMethod()
    {
        return self::METHOD_POST;
    }

    public function getResource()
    {
        return '/contacts/groups';
    }

    protected function response($data)
    {
        return GroupResponse::fromJsonString($data);
    }

    public function setDescription($description)
    {
        $this->params[GroupResponse::FIELD_DESCRIPTION] = $description;

        return $this;
    }

    public function setIdx($idx)
    {
        $this->params[GroupResponse::FIELD_IDX] = $idx;

        return $this;
    }
}
