<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Integration\Feature\Contacts;

use Smsapi\Client\Feature\Contacts\Bag\CreateContactBag;
use Smsapi\Client\Feature\Contacts\Bag\DeleteContactBag;
use Smsapi\Client\Feature\Contacts\Bag\FindContactBag;
use Smsapi\Client\Feature\Contacts\Bag\FindContactsBag;
use Smsapi\Client\Feature\Contacts\Bag\UpdateContactBag;
use Smsapi\Client\Feature\Contacts\ContactsFeature;
use Smsapi\Client\Feature\Contacts\Fields\Bag\CreateContactFieldBag;
use Smsapi\Client\Feature\Contacts\Fields\Bag\DeleteContactFieldBag;
use Smsapi\Client\Feature\Contacts\Fields\Data\ContactField;
use Smsapi\Client\Infrastructure\ResponseMapper\ApiErrorException;
use Smsapi\Client\Tests\Assert\ContactCustomFieldAssert;
use Smsapi\Client\Tests\Fixture\PhoneNumberFixture;
use Smsapi\Client\Tests\SmsapiClientIntegrationTestCase;

class ContactsFeatureTest extends SmsapiClientIntegrationTestCase
{
    /** @var string */
    private static $contactId;

    /** @var ContactsFeature */
    private $feature;

    /**
     * @before
     */
    public function before()
    {
        $this->feature = self::$smsapiService->contactsFeature();
    }

    /**
     * @afterClass
     */
    public function after()
    {
        self::cleanupContact(self::$contactId);
    }

    /**
     * @test
     */
    public function it_should_create_contact(): string
    {
        $contactCreateBag = new CreateContactBag();
        $contactCreateBag->phoneNumber = PhoneNumberFixture::$valid;

        $contact = $this->feature->createContact($contactCreateBag);

        $this->assertEquals($contactCreateBag->phoneNumber, $contact->phoneNumber);

        return $contact->id;
    }

    /**
     * @test
     * @depends it_should_create_contact
     */
    public function it_should_find_contact(string $contactId): string
    {
        $contactFindBag = new FindContactBag($contactId);

        $foundContact = $this->feature->findContact($contactFindBag);

        $this->assertEquals($contactId, $foundContact->id);

        return $foundContact->phoneNumber;
    }

    /**
     * @test
     * @depends it_should_create_contact
     */
    public function it_should_find_all_contacts()
    {
        $foundContacts = $this->feature->findContacts();

        $this->assertGreaterThanOrEqual(1, count($foundContacts));
    }

    /**
     * @test
     * @depends it_should_find_contact
     */
    public function it_should_find_contact_by_phone_number(string $contactPhoneNumber)
    {
        $contactFindBag = new FindContactsBag();
        $contactFindBag->phoneNumber = $contactPhoneNumber;

        $foundContacts = $this->feature->findContacts($contactFindBag);

        $this->assertEquals($contactPhoneNumber, $foundContacts[0]->phoneNumber);
    }

    /**
     * @test
     * @depends it_should_create_contact
     */
    public function it_should_update_contact(string $contactId)
    {
        $contactUpdateBag = new UpdateContactBag($contactId);
        $contactUpdateBag->phoneNumber = PhoneNumberFixture::anyValid();

        $contact = $this->feature->updateContact($contactUpdateBag);

        $this->assertEquals($contactUpdateBag->phoneNumber, $contact->phoneNumber);
    }

    /**
     * @test
     * @depends it_should_create_contact
     */
    public function it_should_set_custom_field(string $contactId)
    {
        $customField = $this->feature->fieldsFeature()->createField(
            new CreateContactFieldBag(uniqid('any'))
        );

        $customFieldValue = 'any';
        $updateContactBag = new UpdateContactBag($contactId);
        $updateContactBag->setCustomField($customField->name, $customFieldValue);

        $updatedContact = $this->feature->updateContact($updateContactBag);

        (new ContactCustomFieldAssert($updatedContact))->assertHasCustomFieldWithValue($customField, $customFieldValue);

        $this->cleanupContactField($customField);
    }

    /**
     * @test
     * @depends it_should_create_contact
     */
    public function it_should_delete_contact(string $contactId)
    {
        $contactDeleteBag = new DeleteContactBag($contactId);
        $contactFindBag = new FindContactBag($contactId);

        $this->expectException(ApiErrorException::class);
        $this->expectExceptionMessage('Cannot find contact');

        $this->feature->deleteContact($contactDeleteBag);
        $this->feature->findContact($contactFindBag);
    }

    /**
     * @test
     */
    public function it_should_delete_all_contacts()
    {
        $this->feature->createContact(CreateContactBag::withPhone(PhoneNumberFixture::anyValid()));
        $this->feature->createContact(CreateContactBag::withPhone(PhoneNumberFixture::anyValid()));

        $this->feature->deleteContacts();

        $foundContacts = $this->feature->findContacts();
        $this->assertEmpty($foundContacts);
    }

    private static function cleanupContact(string $contactId)
    {
        self::$smsapiService
            ->contactsFeature()
            ->deleteContact(
                new DeleteContactBag($contactId)
            );
    }

    private static function cleanupContactField(ContactField $contactField)
    {
        self::$smsapiService
            ->contactsFeature()
            ->fieldsFeature()
            ->deleteField(
                new DeleteContactFieldBag($contactField->id)
            );
    }
}
