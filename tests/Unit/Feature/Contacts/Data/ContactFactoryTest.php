<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Unit\Feature\Contacts\Data;

use DateTime;
use PHPUnit\Framework\TestCase;
use Smsapi\Client\Feature\Contacts\Data\ContactCustomFieldFactory;
use Smsapi\Client\Feature\Contacts\Data\ContactFactory;
use Smsapi\Client\Feature\Contacts\Data\ContactGroupFactory;
use Smsapi\Client\Feature\Contacts\Groups\Permissions\Data\GroupPermissionFactory;
use stdClass;

class ContactFactoryTest extends TestCase
{
    private function createContactsFactory()
    {
        return new ContactFactory(
            new ContactGroupFactory(new GroupPermissionFactory()),
            new ContactCustomFieldFactory()
        );
    }

    /**
     * @test
     */
    public function it_should_convert_mandatory_built_in_contact_fields()
    {
        $contactData = new stdClass();
        $contactData->id = 'any';
        $contactData->date_created = '2020-05-11';
        $contactData->date_updated = '2020-05-12';
        $contactData->gender = 'M';
        $contactData->groups = [];

        $this->assertTrue(true);

        $contact = $this->createContactsFactory()->createFromObject($contactData);

        $this->assertEquals('any', $contact->id);
        $this->assertEquals(new DateTime('2020-05-11'), $contact->dateCreated);
        $this->assertEquals(new DateTime('2020-05-12'), $contact->dateUpdated);
        $this->assertEquals('M', $contact->gender);
    }

    /**
     * @test
     */
    public function it_should_convert_optional_built_in_contact_fields()
    {
        $contactData = $this->givenAnyContactData();
        $contact = $this->createContactsFactory()->createFromObject($contactData);
        $this->assertNull($contact->email);
        $this->assertNull($contact->phoneNumber);
        $this->assertNull($contact->country);
        $this->assertNull($contact->undeliveredMessages);

        $contactData->email = 'any@example.com';
        $contact = $this->createContactsFactory()->createFromObject($contactData);
        $this->assertEquals('any@example.com', $contact->email);

        $contactData->phone_number = '123123123';
        $contact = $this->createContactsFactory()->createFromObject($contactData);
        $this->assertEquals('123123123', $contact->phoneNumber);

        $contactData->country = 'any';
        $contact = $this->createContactsFactory()->createFromObject($contactData);
        $this->assertEquals('any', $contact->country);

        $contactData->undelivered_messages = 1;
        $contact = $this->createContactsFactory()->createFromObject($contactData);
        $this->assertEquals(1, $contact->undeliveredMessages);
    }

    /**
     * @test
     */
    public function it_should_convert_custom_fields()
    {
        $contactData = $this->givenAnyContactData();

        $contactData->custom_field_1 = 'any1';
        $contactData->custom_field_2 = 'any2';

        $contact = $this->createContactsFactory()->createFromObject($contactData);

        $this->assertEquals('custom_field_1', $contact->customFields[0]->name);
        $this->assertEquals('any1', $contact->customFields[0]->value);
        $this->assertEquals('custom_field_2', $contact->customFields[1]->name);
        $this->assertEquals('any2', $contact->customFields[1]->value);
    }

    private function givenAnyContactData(): stdClass
    {
        $contactData = new stdClass();
        $contactData->id = 'any';
        $contactData->date_created = '2020-05-11';
        $contactData->date_updated = '2020-05-12';
        $contactData->gender = 'M';
        $contactData->groups = [];

        return $contactData;
    }
}
