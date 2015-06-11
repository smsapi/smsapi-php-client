<?php

namespace SMSApi\Api\Action\Contacts;

use SMSApi\Api\Response\Contacts\FieldResponse;
use SMSApi\Client;
use SMSApi\Proxy\Proxy;

final class FieldEdit extends ContactsAction
{
    private $fieldId;

    public function __construct($fieldId, Client $client, Proxy $proxy)
    {
        parent::__construct($client, $proxy);

        $this->fieldId = $fieldId;
    }

    public function getMethod()
    {
        return self::METHOD_PUT;
    }

    protected function getResource()
    {
        return strtr('/contacts/fields/:fieldId', [':fieldId' => $this->fieldId]);
    }

    protected function response($data)
    {
        return FieldResponse::fromJsonString($data);
    }

    public function setName($name)
    {
        $this->params[FieldResponse::FIELD_NAME] = $name;

        return $this;
    }

    public function setTypeAsText()
    {
        $this->params[FieldResponse::FIELD_TYPE] = FieldResponse::TYPE_TEXT;

        return $this;
    }

    public function setTypeAsDate()
    {
        $this->params[FieldResponse::FIELD_TYPE] = FieldResponse::TYPE_DATE;

        return $this;
    }

    public function setTypeAsEmail()
    {
        $this->params[FieldResponse::FIELD_TYPE] = FieldResponse::TYPE_EMAIL;

        return $this;
    }

    public function setTypeAsNumber()
    {
        $this->params[FieldResponse::FIELD_TYPE] = FieldResponse::TYPE_NUMBER;

        return $this;
    }

    public function setTypeAsPhoneNumber()
    {
        $this->params[FieldResponse::FIELD_TYPE] = FieldResponse::TYPE_PHONE_NUMBER;

        return $this;
    }
}
