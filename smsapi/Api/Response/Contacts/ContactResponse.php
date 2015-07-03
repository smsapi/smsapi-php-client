<?php

namespace SMSApi\Api\Response\Contacts;

use DateTime;

final class ContactResponse extends AbstractContactsResponse implements IdentifiableResponse
{
    const GENDER_UNDEFINED = 'undefined';
    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';

    const FIELD_GENDER = 'gender';
    const FIELD_PHONE_NUMBER = 'phone_number';
    const FIELD_EMAIL = 'email';
    const FIELD_FIRST_NAME = 'first_name';
    const FIELD_LAST_NAME = 'last_name';
    const FIELD_BIRTHDAY_DATE = 'birthday_date';
    const FIELD_DESCRIPTION = 'description';
    const FIELD_CITY = 'city';
    const FIELD_SOURCE = 'source';

    /** @var string */
    private $id;

    /** @var int|null */
    private $phoneNumber;

    /** @var string|null */
    private $email;

    /** @var string|null */
    private $firstName;

    /** @var string|null */
    private $lastName;

    /** @var string|null */
    private $gender;

    /** @var DateTime|null */
    private $birthdayDate;

    /** @var string|null */
    private $description;

    /** @var string|null */
    private $city;

    /** @var string|null */
    private $source;

    public function __construct(array $data)
    {
        $this->id = $data[self::FIELD_ID];
        $this->phoneNumber = $data[self::FIELD_PHONE_NUMBER];
        $this->email = $data[self::FIELD_EMAIL];
        $this->firstName = $data[self::FIELD_FIRST_NAME];
        $this->lastName = $data[self::FIELD_LAST_NAME];
        $this->description = $data[self::FIELD_DESCRIPTION];
        $this->city = $data[self::FIELD_CITY];
        $this->source = $data[self::FIELD_SOURCE];
        $this->gender = $data[self::FIELD_GENDER];

        if ($data[self::FIELD_BIRTHDAY_DATE]) {
            $this->birthdayDate = new DateTime($data[self::FIELD_BIRTHDAY_DATE]);
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function getBirthdayDate()
    {
        return $this->birthdayDate;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getSource()
    {
        return $this->source;
    }
}
