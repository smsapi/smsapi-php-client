<?php

namespace SMSApi\Api\Action\Contacts;

use DateTime;
use SMSApi\Api\Response\Contacts\ContactResponse;
use SMSApi\Api\Response\Contacts\ContactsResponse;

/**
 * @method ContactsResponse execute()
 */
final class ContactList extends ContactsAction
{
    const PARAM_SEARCH = 'q';
    const PARAM_OFFSET = 'offset';
    const PARAM_LIMIT = 'limit';
    const PARAM_ORDER_BY = 'order_by';

    public function getMethod()
    {
        return self::METHOD_GET;
    }

    public function getResource()
    {
        return '/contacts';
    }

    protected function response($data)
    {
        return ContactsResponse::fromJsonString($data);
    }

    public function setSearch($search)
    {
        $this->setParam(self::PARAM_SEARCH, $search);

        return $this;
    }

    public function setOffsetAndLimit($offset, $limit)
    {
        $this
            ->setParam(self::PARAM_OFFSET, $offset)
            ->setParam(self::PARAM_LIMIT, $limit);

        return $this;
    }

    public function setOrderBy($orderBy)
    {
        $this->setParam(self::PARAM_ORDER_BY, $orderBy);

        return $this;
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

    public function setBirthDayDate(DateTime $birthdayDate)
    {
        $this->setParam(ContactResponse::FIELD_BIRTHDAY_DATE, $birthdayDate->format('Y-m-d'));

        return $this;
    }

    public function setIds(array $ids)
    {
        $this->params[ContactResponse::FIELD_ID] = $ids;

        return $this;
    }
}
