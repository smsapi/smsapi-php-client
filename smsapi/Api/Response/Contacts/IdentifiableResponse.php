<?php

namespace SMSApi\Api\Response\Contacts;

interface IdentifiableResponse
{
    const FIELD_ID = 'id';

    public function getId();
}
