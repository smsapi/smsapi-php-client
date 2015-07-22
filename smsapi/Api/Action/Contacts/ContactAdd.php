<?php

namespace SMSApi\Api\Action\Contacts;

use DateTime;
use SMSApi\Api\Response\Contacts\ContactResponse;

/**
 * @method ContactResponse execute()
 */
abstract class ContactAdd extends ContactsAction
{
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

    public function setFirstName($firstName)
    {
        $this->setParamValue(ContactResponse::FIELD_FIRST_NAME, $firstName);

        return $this;
    }

    public function setLastName($lastName)
    {
        $this->setParamValue(ContactResponse::FIELD_LAST_NAME, $lastName);

        return $this;
    }

    public function setGenderAsMale()
    {
        $this->setParamValue(ContactResponse::FIELD_GENDER, ContactResponse::GENDER_MALE);

        return $this;
    }

    public function setGenderAsFemale()
    {
        $this->setParamValue(ContactResponse::FIELD_GENDER, ContactResponse::GENDER_FEMALE);

        return $this;
    }

    public function setGenderAsUndefined()
    {
        $this->setParamValue(ContactResponse::FIELD_GENDER, ContactResponse::GENDER_UNDEFINED);

        return $this;
    }

    public function setBirthdayDate(DateTime $birthdayDate)
    {
        $this->params[ContactResponse::FIELD_BIRTHDAY_DATE] = $birthdayDate->format('Y-m-d');

        return $this;
    }

    public function setDescription($description)
    {
        $this->setParamValue(ContactResponse::FIELD_DESCRIPTION, $description);

        return $this;
    }

    public function setCity($city)
    {
        $this->setParamValue(ContactResponse::FIELD_CITY, $city);

        return $this;
    }

    public function setSource($source)
    {
        $this->setParamValue(ContactResponse::FIELD_SOURCE, $source);

        return $this;
    }
}
