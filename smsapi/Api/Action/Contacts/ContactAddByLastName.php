<?php

namespace SMSApi\Api\Action\Contacts;

use SMSApi\Api\Response\Contacts\ContactResponse;
use SMSApi\Client;
use SMSApi\Proxy\Proxy;

final class ContactAddByLastName extends ContactAdd
{
    /**
     * @param string $lastName
     * @param Client $client
     * @param Proxy $proxy
     */
    public function __construct($lastName, Client $client, Proxy $proxy)
    {
        parent::__construct($client, $proxy);

        $this->params[ContactResponse::FIELD_LAST_NAME] = $lastName;
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

    public function setFirstName($firstName)
    {
        $this->params[ContactResponse::FIELD_FIRST_NAME] = $firstName;

        return $this;
    }
}
