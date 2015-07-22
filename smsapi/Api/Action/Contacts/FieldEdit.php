<?php

namespace SMSApi\Api\Action\Contacts;

use SMSApi\Api\Response\Contacts\FieldResponse;
use SMSApi\Client;
use SMSApi\Proxy\Proxy;

/**
 * @method FieldResponse execute()
 */
final class FieldEdit extends ContactsAction
{
    private $id;

    public function __construct($id, Client $client, Proxy $proxy)
    {
        parent::__construct($client, $proxy);

        $this->id = $id;
    }

    public function getMethod()
    {
        return self::METHOD_PUT;
    }

    protected function getResource()
    {
        return strtr('/contacts/fields/:id', array(':id' => urlencode($this->id)));
    }

    protected function response($data)
    {
        return FieldResponse::fromJsonString($data);
    }

    public function setName($name)
    {
        $this->setParam(FieldResponse::FIELD_NAME, $name);

        return $this;
    }

    public function setTypeAsText()
    {
        $this->setParam(FieldResponse::FIELD_TYPE, FieldResponse::TYPE_TEXT);

        return $this;
    }

    public function setTypeAsDate()
    {
        $this->setParam(FieldResponse::FIELD_TYPE, FieldResponse::TYPE_DATE);

        return $this;
    }

    public function setTypeAsEmail()
    {
        $this->setParam(FieldResponse::FIELD_TYPE, FieldResponse::TYPE_EMAIL);

        return $this;
    }

    public function setTypeAsNumber()
    {
        $this->setParam(FieldResponse::FIELD_TYPE, FieldResponse::TYPE_NUMBER);

        return $this;
    }

    public function setTypeAsPhoneNumber()
    {
        $this->setParam(FieldResponse::FIELD_TYPE, FieldResponse::TYPE_PHONE_NUMBER);

        return $this;
    }
}
