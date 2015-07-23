<?php

namespace SMSApi\Api\Response\Contacts;

interface CountableResponse
{
    const FIELD_SIZE = 'size';

    public function getSize();
}
