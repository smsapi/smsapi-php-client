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

        $this->params[ContactResponse::FIELD_EMAIL] = $email;
    }

    public function setPhoneNumber($phoneNumber)
    {
        $this->params[ContactResponse::FIELD_PHONE_NUMBER] = $phoneNumber;

        return $this;
    }

    public function setFirstName($firstName)
    {
        $this->params[ContactResponse::FIELD_FIRST_NAME] = $firstName;

        return $this;
    }

    public function setLastName($lastName)
    {
        $this->params[ContactResponse::FIELD_LAST_NAME] = $lastName;

        return $this;
    }
}
