<?php

namespace SMSApi\Api\Response\Contacts;

final class FieldResponse extends AbstractContactsResponse
{
    const TYPE_TEXT = 'text';
    const TYPE_DATE = 'date';
    const TYPE_EMAIL = 'email';
    const TYPE_NUMBER = 'number';
    const TYPE_PHONE_NUMBER = 'phone_number';

    const FIELD_ID = 'id';
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
