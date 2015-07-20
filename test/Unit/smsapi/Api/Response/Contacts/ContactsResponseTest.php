<?php

namespace SMSApi\Api\Response\Contacts;

use PHPUnit_Framework_TestCase;

class ContactsResponseTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_return_array_of_contact_responses()
    {
        $someContacts = $this->createContacts();
        $testedObject = new ContactsResponse($someContacts);

        $result = $testedObject->getCollection();

        $this->assertInstanceOf('SMSApi\Api\Response\Contacts\ContactResponse', $result[0]);
    }

    /**
     * @return array
     */
    private function createContacts()
    {
        return array(
            ContactsResponse::FIELD_SIZE => 1,
            ContactsResponse::FIELD_COLLECTION => array(
                array(
                    ContactResponse::FIELD_ID => 1,
                    ContactResponse::FIELD_PHONE_NUMBER => null,
                    ContactResponse::FIELD_EMAIL => null,
                    ContactResponse::FIELD_FIRST_NAME => null,
                    ContactResponse::FIELD_LAST_NAME => null,
                    ContactResponse::FIELD_DESCRIPTION => null,
                    ContactResponse::FIELD_BIRTHDAY_DATE => null,
                    ContactResponse::FIELD_GENDER => null,
                    ContactResponse::FIELD_CITY => null,
                    ContactResponse::FIELD_SOURCE => null,
                ),
            ),
        );
    }
}
