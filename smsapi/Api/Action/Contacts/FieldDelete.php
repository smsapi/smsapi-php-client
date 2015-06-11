<?php

namespace SMSApi\Api\Action\Contacts;

use SMSApi\Api\Response\RawResponse;
use SMSApi\Client;
use SMSApi\Proxy\Proxy;

final class FieldDelete extends ContactsAction
{
    private $fieldId;

    public function __construct($fieldId, Client $client, Proxy $proxy)
    {
        parent::__construct($client, $proxy);

        $this->fieldId = $fieldId;
    }

    public function getMethod()
    {
        return self::METHOD_DELETE;
    }

    protected function getResource()
    {
        return strtr('/contacts/fields/:fieldId', [':fieldId' => $this->fieldId]);
    }

    protected function response($data)
    {
        return new RawResponse($data);
    }
}
