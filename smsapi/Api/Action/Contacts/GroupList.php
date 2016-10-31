<?php

namespace SMSApi\Api\Action\Contacts;

use SMSApi\Api\Response\Contacts\GroupResponse;
use SMSApi\Api\Response\Contacts\GroupsResponse;
use SMSApi\Client;
use SMSApi\Proxy\Proxy;

/**
 * @method GroupsResponse execute()
 */
final class GroupList extends ContactsAction
{
    public function __construct(Client $client, Proxy $proxy)
    {
        parent::__construct($client, $proxy);

        $this->setParamValue('with', 'contacts_count');
    }

    public function getMethod()
    {
        return self::METHOD_GET;
    }

    public function getResource()
    {
        return '/contacts/groups';
    }

    protected function response($data)
    {
        return GroupsResponse::fromJsonString($data);
    }

    public function setIds(array $ids)
    {
        $this->setParamValue(GroupResponse::FIELD_ID, $ids);

        return $this;
    }

    public function setNames(array $names)
    {
        $this->setParamValue(GroupResponse::FIELD_NAME, $names);

        return $this;
    }
}
