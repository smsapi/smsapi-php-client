<?php

namespace SMSApi\Api\Action\Contacts;

use SMSApi\Api\Response\Contacts\FieldResponse;
use SMSApi\Client;
use SMSApi\Proxy\Proxy;

/**
 * @method FieldResponse execute()
 */
final class FieldAdd extends ContactsAction
{
    public function __construct($name, Client $client, Proxy $proxy)
    {
        parent::__construct($client, $proxy);

        $this->setParamValue(FieldResponse::FIELD_NAME, $name);
    }

    public function getMethod()
    {
        return self::METHOD_POST;
    }

    protected function getResource()
    {
        return '/contacts/fields';
    }

    protected function response($data)
    {
        return FieldResponse::fromJsonString($data);
    }

    public function setTypeAsText()
    {
        $this->setParamValue(FieldResponse::FIELD_TYPE, FieldResponse::TYPE_TEXT);

        return $this;
    }

    public function setTypeAsDate()
    {
        $this->setParamValue(FieldResponse::FIELD_TYPE, FieldResponse::TYPE_DATE);

        return $this;
    }

    public function setTypeAsEmail()
    {
        $this->setParamValue(FieldResponse::FIELD_TYPE, FieldResponse::TYPE_EMAIL);

        return $this;
    }

    public function setTypeAsNumber()
    {
        $this->setParamValue(FieldResponse::FIELD_TYPE, FieldResponse::TYPE_NUMBER);

        return $this;
    }

    public function setTypeAsPhoneNumber()
    {
        $this->setParamValue(FieldResponse::FIELD_TYPE, FieldResponse::TYPE_PHONE_NUMBER);

        return $this;
    }
}
