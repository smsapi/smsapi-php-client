<?php

namespace SMSApi\Api\Action\Contacts;

use SMSApi\Api\Response\Contacts\ContactResponse;
use SMSApi\Client;
use SMSApi\Proxy\Proxy;

final class ContactAddByEmail extends ContactAdd
{
    /**
     * @param string $email
     * @param Client $client
     * @param Proxy $proxy
     */
    public function __construct($email, Client $client, Proxy $proxy)
    {
        parent::__construct($client, $proxy);

        $this->setParamValue(ContactResponse::FIELD_EMAIL, $email);
    }

    public function setPhoneNumber($phoneNumber)
    {
        $this->setParamValue(ContactResponse::FIELD_PHONE_NUMBER, $phoneNumber);

        return $this;
    }
}
