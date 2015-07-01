<?php

namespace SMSApi\Api\Response\Contacts;

use SMSApi\Api\Response\Response;

abstract class AbstractContactsResponse implements Response
{
    public static function fromJsonString($jsonString)
    {
        return new static(json_decode($jsonString, true));
    }
}
