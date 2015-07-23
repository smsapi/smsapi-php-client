<?php

namespace SMSApi\Api\Response\Contacts;

final class SizeResponse extends AbstractContactsResponse implements CountableResponse
{
    /** @var int */
    private $size;

    function __construct(array $data)
    {
        $this->size = $data[self::FIELD_SIZE];
    }

    public function getSize()
    {
        return $this->size;
    }
}
