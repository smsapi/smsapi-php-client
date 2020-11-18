<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Integration\Feature\Contacts\Fields;

use Smsapi\Client\Feature\Contacts\Bag\CreateContactBag;
use Smsapi\Client\Feature\Contacts\Bag\DeleteContactBag;
use Smsapi\Client\Feature\Contacts\Fields\Bag\CreateContactFieldBag;
use Smsapi\Client\Feature\Contacts\Fields\Bag\DeleteContactFieldBag;
use Smsapi\Client\Feature\Contacts\Fields\Bag\FindContactFieldOptionsBag;
use Smsapi\Client\Feature\Contacts\Fields\Bag\UpdateContactFieldBag;
use Smsapi\Client\Feature\Contacts\Fields\ContactsFieldsFeature;
use Smsapi\Client\Tests\Assert\ContactFieldsAssert;
use Smsapi\Client\Tests\Fixture\PhoneNumberFixture;
use Smsapi\Client\Tests\SmsapiClientIntegrationTestCase;

class ContactsFieldsFeatureTest extends SmsapiClientIntegrationTestCase
{

    /** @var ContactsFieldsFeature */
    private $feature;

    /** @var ContactFieldsAssert */
    private $assert;

    /**
     * @before
     */
    public function before()
    {
        $this->feature = self::$smsapiService->contactsFeature()->fieldsFeature();
        $this->assert = new ContactFieldsAssert();
    }

    /**
     * @test
     */
    public function it_should_create_contact_field(): string
    {
        $createContactFieldBag = new CreateContactFieldBag('anyName');
        $createContactFieldBag->type = 'TEXT';

        $contactField = $this->feature->createField($createContactFieldBag);

        $this->assertEquals($createContactFieldBag->name, $contactField->name);
        $this->assertEquals($createContactFieldBag->type, $contactField->type);

        return $contactField->id;
    }

    /**
     * @test
     * @depends it_should_create_contact_field
     */
    public function it_should_find_contact_fields(string $fieldId)
    {
        $contactFields = $this->feature->findFields();

        $this->assertNotEmpty($contactFields);
        $this->assert->assertFieldIdInCollection($fieldId, $contactFields);
    }

    /**
     * @test
     * @depends it_should_create_contact_field
     */
    public function it_should_update_contact_field(string $fieldId)
    {
        $updateContactFieldBag = new UpdateContactFieldBag($fieldId, 'newName');

        $contactField = $this->feature->updateField($updateContactFieldBag);

        $this->assertEquals($updateContactFieldBag->name, $contactField->name);
    }

    /**
     * @test
     * @depends it_should_create_contact_field
     */
    public function it_should_delete_contact_field(string $fieldId)
    {
        $deleteContactFieldBag = new DeleteContactFieldBag($fieldId);

        $this->feature->deleteField($deleteContactFieldBag);
        $contactFields = $this->feature->findFields();

        $this->assert->assertFieldIdNotInCollection($fieldId, $contactFields);
    }

    /**
     * @test
     */
    public function it_should_find_contact_field_options()
    {
        $createContactBag = new CreateContactBag();
        $createContactBag->gender = 'male';
        $createContactBag->phoneNumber = PhoneNumberFixture::$validMobile;
        $contact = self::$smsapiService->contactsFeature()->createContact($createContactBag);

        $findContactFieldOptionsBag = new FindContactFieldOptionsBag('gender');

        $options = $this->feature->findFieldOptions($findContactFieldOptionsBag);

        $this->assertNotEmpty($options);

        self::$smsapiService->contactsFeature()->deleteContact(new DeleteContactBag($contact->id));
    }
}
