<?php

namespace SMSApi\Api\Action\Contacts;

use SMSApi\Api\Response\Contacts\DeleteResponse;
use SMSApi\Client;
use SMSApi\Proxy\Proxy;

/**
 * @method DeleteResponse execute()
 */
final class FieldDelete extends ContactsAction
{
    private $id;

    public function __construct($id, Client $client, Proxy $proxy)
    {
        parent::__construct($client, $proxy);

        $this->id = $id;
    }

    public function getMethod()
    {
        return self::METHOD_DELETE;
    }

    protected function getResource()
    {
        return strtr('/contacts/fields/:id', array(':id' => urlencode($this->id)));
    }

    protected function response($data)
    {
        return new DeleteResponse;
    }
}
