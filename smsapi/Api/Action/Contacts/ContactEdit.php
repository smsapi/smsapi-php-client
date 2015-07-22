<?php

namespace SMSApi\Api\Action\Contacts;

use DateTime;
use SMSApi\Api\Response\Contacts\ContactResponse;
use SMSApi\Client;
use SMSApi\Proxy\Proxy;

/**
 * @method ContactResponse execute()
 */
class ContactEdit extends ContactsAction
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
        $this->setParam(ContactResponse::FIELD_PHONE_NUMBER, $phoneNumber);

        return $this;
    }

    public function setEmail($email)
    {
        $this->setParam(ContactResponse::FIELD_EMAIL, $email);

        return $this;
    }

    public function setFirstName($firstName)
    {
        $this->setParam(ContactResponse::FIELD_FIRST_NAME, $firstName);

        return $this;
    }

    public function setLastName($lastName)
    {
        $this->setParam(ContactResponse::FIELD_LAST_NAME, $lastName);

        return $this;
    }

    public function setGenderAsMale()
    {
        $this->setParam(ContactResponse::FIELD_GENDER, ContactResponse::GENDER_MALE);

        return $this;
    }

    public function setGenderAsFemale()
    {
        $this->setParam(ContactResponse::FIELD_GENDER, ContactResponse::GENDER_FEMALE);

        return $this;
    }

    public function setGenderAsUndefined()
    {
        $this->setParam(ContactResponse::FIELD_GENDER, ContactResponse::GENDER_UNDEFINED);

        return $this;
    }

    public function setBirthdayDate(DateTime $birthdayDate)
    {
        $this->params[ContactResponse::FIELD_BIRTHDAY_DATE] = $birthdayDate->format('Y-m-d');

        return $this;
    }

    public function setDescription($description)
    {
        $this->setParam(ContactResponse::FIELD_DESCRIPTION, $description);

        return $this;
    }

    public function setCity($city)
    {
        $this->setParam(ContactResponse::FIELD_CITY, $city);

        return $this;
    }

    public function setSource($source)
    {
        $this->setParam(ContactResponse::FIELD_SOURCE, $source);

        return $this;
    }
}
