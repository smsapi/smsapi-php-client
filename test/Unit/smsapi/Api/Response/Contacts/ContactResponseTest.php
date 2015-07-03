<?php

namespace SMSApi\Api\Response\Contacts;

use PHPUnit_Framework_TestCase;

class ContactResponseTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_set_birthday_if_is_not_empty()
    {
        $notEmptyBirthdayDate = '2015-06-09';
        $testedObject = $this->createContactResponseWithBirthday($notEmptyBirthdayDate);

        $result = $testedObject->getBirthdayDate();

        $this->assertNotNull($result);
    }

    /**
     * @test
     */
    public function it_should_not_set_birthday_if_is_empty()
    {
        $emptyBirthdayDate = null;
        $testedObject = $this->createContactResponseWithBirthday($emptyBirthdayDate);

        $result = $testedObject->getBirthdayDate();

        $this->assertNull($result);
    }

    private function createContactResponseWithBirthday($birthdayDate)
    {
        return self::createContactResponse($birthdayDate);
    }

    private function createContactResponse($birthdayDate)
    {
        return new ContactResponse(
            array(
                ContactResponse::FIELD_ID => 1,
                ContactResponse::FIELD_PHONE_NUMBER => null,
                ContactResponse::FIELD_EMAIL => null,
                ContactResponse::FIELD_FIRST_NAME => null,
                ContactResponse::FIELD_LAST_NAME => null,
                ContactResponse::FIELD_DESCRIPTION => null,
                ContactResponse::FIELD_GENDER => null,
                ContactResponse::FIELD_BIRTHDAY_DATE => $birthdayDate,
                ContactResponse::FIELD_CITY => null,
                ContactResponse::FIELD_SOURCE => null,
            )
        );
    }
}
