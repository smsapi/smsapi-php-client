<?php

namespace SMSApi\Api\Action\Contacts;

use DateTime;
use InvalidArgumentException;
use SMSApi\Api\Response\Contacts\ContactResponse;
use SMSApi\Client;
use SMSApi\Proxy\Proxy;

final class ContactAdd extends ContactsAction
{
    private static $PARAMETER_METHODS = [
        ContactResponse::FIELD_FIRST_NAME => 'setFirstName',
        ContactResponse::FIELD_LAST_NAME => 'setLastName',
        ContactResponse::FIELD_PHONE_NUMBER => 'setPhoneNumber',
        ContactResponse::FIELD_EMAIL => 'setEmail',
    ];

    public static function fromFirstName($firstName, Client $client, Proxy $proxy)
    {
        return new self(ContactResponse::FIELD_FIRST_NAME, $firstName, $client, $proxy);
    }

    public static function fromLastName($lastName, Client $client, Proxy $proxy)
    {
        return new self(ContactResponse::FIELD_LAST_NAME, $lastName, $client, $proxy);
    }

    public static function fromPhoneNumber($phoneNumber, Client $client, Proxy $proxy)
    {
        return new self(ContactResponse::FIELD_PHONE_NUMBER, $phoneNumber, $client, $proxy);
    }

    public static function fromEmail($email, Client $client, Proxy $proxy)
    {
        return new self(ContactResponse::FIELD_EMAIL, $email, $client, $proxy);
    }

    /**
     * @param string $parameterName
     * @param string|int $parameterValue
     * @param Client $client
     * @param Proxy $proxy
     */
    public function __construct($parameterName, $parameterValue, Client $client, Proxy $proxy)
    {
        parent::__construct($client, $proxy);

        $this->{self::$PARAMETER_METHODS[$parameterName]} = $parameterValue;
    }

    public function getMethod()
    {
        return self::METHOD_POST;
    }

    protected function getResource()
    {
        return '/contacts';
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
