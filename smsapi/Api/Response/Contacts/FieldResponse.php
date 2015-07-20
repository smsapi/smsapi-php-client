<?php

namespace SMSApi\Api\Response\Contacts;

final class FieldResponse extends AbstractContactsResponse implements IdentifiableResponse
{
    const TYPE_TEXT = 'TEXT';
    const TYPE_DATE = 'DATE';
    const TYPE_EMAIL = 'EMAIL';
    const TYPE_NUMBER = 'NUMBER';
    const TYPE_PHONE_NUMBER = 'PHONE_NUMBER';

    const FIELD_NAME = 'name';
    const FIELD_TYPE = 'type';

    private $id;
    private $name;
    private $type;

    public function __construct(array $data)
    {
        $this->id = $data[self::FIELD_ID];
        $this->name = $data[self::FIELD_NAME];
        $this->type = $data[self::FIELD_TYPE];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type;
    }
}
