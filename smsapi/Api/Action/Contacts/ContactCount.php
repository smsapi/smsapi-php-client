<?php

namespace SMSApi\Api\Action\Contacts;

use DateTime;
use SMSApi\Api\Response\Contacts\ContactResponse;
use SMSApi\Api\Response\Contacts\SizeResponse;

/**
 * @method SizeResponse execute()
 */
class ContactCount extends ContactsAction
{
    const PARAM_SEARCH = 'q';
    const PARAM_GROUP_ID = 'group_id';

    public function getMethod()
    {
        return self::METHOD_HEAD;
    }

    public function getResource()
    {
        return '/contacts';
    }

    protected function response($data)
    {
        return SizeResponse::fromJsonString($data);
    }

    public function setSearch($search)
    {
        $this->setParamValue(self::PARAM_SEARCH, $search);

        return $this;
    }

    public function setPhoneNumber($phoneNumber)
    {
        $this->setParamValue(ContactResponse::FIELD_PHONE_NUMBER, $phoneNumber);

        return $this;
    }

    public function setEmail($email)
    {
        $this->setParamValue(ContactResponse::FIELD_EMAIL, $email);

        return $this;
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

    public function setBirthDayDate(DateTime $birthdayDate)
    {
        $this->setParamValue(ContactResponse::FIELD_BIRTHDAY_DATE, $birthdayDate->format('Y-m-d'));

        return $this;
    }

    public function setIds(array $ids)
    {
        $this->setParamArray(ContactResponse::FIELD_ID, $ids);

        return $this;
    }

    public function setGroupId($groupId)
    {
        $this->setParamValue(self::PARAM_GROUP_ID, $groupId);

        return $this;
    }

    public function setGroupIds(array $groupIds)
    {
        $this->setParamArray(self::PARAM_GROUP_ID, $groupIds);

        return $this;
    }
}
