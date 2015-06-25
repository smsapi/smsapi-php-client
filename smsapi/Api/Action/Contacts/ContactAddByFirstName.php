<?php

namespace SMSApi\Api\Action\Contacts;

use SMSApi\Api\Response\Contacts\ContactResponse;
use SMSApi\Client;
use SMSApi\Proxy\Proxy;

final class ContactAddByFirstName extends ContactAdd
{
    /**
     * @param string $firstName
     * @param Client $client
     * @param Proxy $proxy
     */
    public function __construct($firstName, Client $client, Proxy $proxy)
    {
        parent::__construct($client, $proxy);

        $this->params[ContactResponse::FIELD_FIRST_NAME] = $firstName;
    }

    public function setPhoneNumber($phoneNumber)
    {
        $this->params[ContactResponse::FIELD_PHONE_NUMBER] = $phoneNumber;

        return $this;
    }

    public function setEmail($email)
    {
        $this->params[ContactResponse::FIELD_EMAIL] = $email;

        return $this;
    }

    public function setLastName($lastName)
    {
        $this->params[ContactResponse::FIELD_LAST_NAME] = $lastName;

        return $this;
    }
}
