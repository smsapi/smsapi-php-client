<?php

namespace SMSApi\Api\Action\Contacts;

use DateTime;
use SMSApi\Api\Response\Contacts\ContactResponse;

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
