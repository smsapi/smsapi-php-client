<?php

namespace SMSApi\Api\Response\Contacts;

final class OptionResponse extends AbstractContactsResponse
{
    const FIELD_NAME = 'name';
    const FIELD_VALUE = 'value';

    private $name;
    private $value;

    public function __construct(array $data)
    {
        $this->name = $data[self::FIELD_NAME];
        $this->value = $data[self::FIELD_VALUE];
    }

    public function getName()
    {
        return $this->name;
    }

    public function getValue()
    {
        return $this->value;
    }
}
