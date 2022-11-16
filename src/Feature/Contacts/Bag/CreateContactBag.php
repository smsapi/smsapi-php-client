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
#[\AllowDynamicProperties]
class CreateContactBag
{
    /**
     * @deprecated
     * @see withPhoneNumber
     */
    public static function withPhone(string $phoneNumber): self
    {
        return self::withPhoneNumber($phoneNumber);
    }

    public static function withPhoneNumber(string $phoneNumber): self
    {
        $bag = new self();
        $bag->phoneNumber = $phoneNumber;
        return $bag;

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
