<?php

namespace SMSApi\Api\Action\Contacts;

use SMSApi\Api\Response\Contacts\OptionResponse;
use SMSApi\Client;
use SMSApi\Proxy\Proxy;

final class FieldOptionList extends ContactsAction
{
    private $fieldId;

    public function __construct($fieldId, Client $client, Proxy $proxy)
    {
        parent::__construct($client, $proxy);

        $this->fieldId = $fieldId;
    }

    public function getMethod()
    {
        return self::METHOD_GET;
    }

    protected function getResource()
    {
        return strtr('/contacts/fields/:fieldId/options', array(':fieldId' => $this->fieldId));
    }

    protected function response($data)
    {
        return OptionResponse::fromJsonString($data);
    }
}
