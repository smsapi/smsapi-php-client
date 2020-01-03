<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Contacts\Bag;

/**
 * @api
 * @property string $phoneNumber
 * @property string $email
 * @property string $firstName
 * @property string $lastName
 * @property string $gender
 * @property string $birthdayDate
 * @property string $description
 * @property string $city
 * @property string $source
 */
class CreateContactBag
{
    public static function withPhone(string $phoneNumber): self
    {
        $bag = new self();
        $bag->phoneNumber = $phoneNumber;
        return $bag;
    }

    /**
     * @deprecated
     * @see withPhone
     */
    public static function withPhoneNumber(int $phoneNumber): self
    {
        return self::withPhone((string)$phoneNumber);
    }

    public static function withEmail(string $email): self
    {
        $bag = new self();
        $bag->email = $email;
        return $bag;
    }

    public function setName(string $firstName, string $lastName): self
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        return $this;
    }

    public function setCustomField(string $name, string $value): self
    {
        $this->$name = $value;
        return $this;
    }
}
