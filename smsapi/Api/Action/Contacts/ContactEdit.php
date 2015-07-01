<?php

namespace SMSApi\Api\Action\Contacts;

use DateTime;
use SMSApi\Api\Response\Contacts\ContactResponse;
use SMSApi\Client;
use SMSApi\Proxy\Proxy;

class ContactsEdit extends ContactsAction
{
    private $contactId;

    public function __construct($contactId, Client $client, Proxy $proxy)
    {
        parent::__construct($client, $proxy);

        $this->contactId = $contactId;
    }

    public function getMethod()
    {
        return self::METHOD_PUT;
    }

    public function getResource()
    {
        return strtr('/contacts/:contactId', array(':contactId' => $this->contactId));
    }

    protected function response($data)
    {
        return ContactResponse::fromJsonString($data);
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

    public function setLastName($lastName)
    {
        $this->params[ContactResponse::FIELD_LAST_NAME] = $lastName;

        return $this;
    }

    public function setGenderAsMale()
    {
        $this->params[ContactResponse::FIELD_GENDER] = ContactResponse::GENDER_MALE;

        return $this;
    }

    public function setGenderAsFemale()
    {
        $this->params[ContactResponse::FIELD_GENDER] = ContactResponse::GENDER_FEMALE;

        return $this;
    }

    public function setGenderAsUndefined()
    {
        $this->params[ContactResponse::FIELD_GENDER] = ContactResponse::GENDER_UNDEFINED;

        return $this;
    }

    public function setBirthdayDate(DateTime $birthdayDate)
    {
        $this->params[ContactResponse::FIELD_BIRTHDAY_DATE] = $birthdayDate->format('Y-m-d');

        return $this;
    }

    public function setDescription($description)
    {
        $this->params[ContactResponse::FIELD_DESCRIPTION] = $description;

        return $this;
    }
}
