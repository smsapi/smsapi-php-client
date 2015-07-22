<?php

namespace SMSApi\Api\Action\Contacts;

use SMSApi\Api\Response\Contacts\ContactResponse;
use SMSApi\Client;
use SMSApi\Proxy\Proxy;

final class ContactAddByPhoneNumber extends ContactAdd
{
    /**
     * @param int $phoneNumber
     * @param Client $client
     * @param Proxy $proxy
     */
    public function __construct($phoneNumber, Client $client, Proxy $proxy)
    {
        parent::__construct($client, $proxy);

        $this->setParamValue(ContactResponse::FIELD_PHONE_NUMBER, $phoneNumber);
    }

    public function setEmail($email)
    {
        $this->setParamValue(ContactResponse::FIELD_EMAIL, $email);

        return $this;
    }
}
