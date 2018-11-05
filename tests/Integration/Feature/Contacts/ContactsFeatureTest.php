<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Integration\Feature\Contacts;

use Smsapi\Client\Feature\Contacts\Bag\CreateContactBag;
use Smsapi\Client\Feature\Contacts\Bag\DeleteContactBag;
use Smsapi\Client\Feature\Contacts\Bag\FindContactBag;
use Smsapi\Client\Feature\Contacts\Bag\FindContactsBag;
use Smsapi\Client\Feature\Contacts\Bag\UpdateContactBag;
use Smsapi\Client\Feature\Contacts\ContactsFeature;
use Smsapi\Client\Infrastructure\ResponseMapper\ApiErrorException;
use Smsapi\Client\Tests\SmsapiClientIntegrationTestCase;

class ContactsFeatureTest extends SmsapiClientIntegrationTestCase
{

    const CONTACT_PHONE_NUMBER_1 = 48123123123;
    const CONTACT_PHONE_NUMBER_2 = 48123123124;

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
        self::cleanupContact(self::CONTACT_PHONE_NUMBER_1);
        self::cleanupContact(self::CONTACT_PHONE_NUMBER_2);
    }

    /**
     * @test
     */
    public function it_should_create_contact(): string
    {
        $contactCreateBag = new CreateContactBag();
        $contactCreateBag->phoneNumber = self::CONTACT_PHONE_NUMBER_1;

        $contact = $this->feature->createContact($contactCreateBag);

        $this->assertEquals(self::CONTACT_PHONE_NUMBER_1, $contact->phoneNumber);

        return $contact->id;
    }

    /**
     * @test
     * @depends it_should_create_contact
     */
    public function it_should_find_contact(string $contactId)
    {
        $contactFindBag = new FindContactBag($contactId);

        $foundContact = $this->feature->findContact($contactFindBag);

        $this->assertEquals(self::CONTACT_PHONE_NUMBER_1, $foundContact->phoneNumber);
    }

    /**
     * @test
     * @depends it_should_create_contact
     */
    public function it_should_find_contact_by_phone_number()
    {
        $contactFindBag = new FindContactsBag();
        $contactFindBag->phoneNumber = self::CONTACT_PHONE_NUMBER_1;

        $foundContacts = $this->feature->findContacts($contactFindBag);

        $this->assertEquals(self::CONTACT_PHONE_NUMBER_1, $foundContacts[0]->phoneNumber);
    }

    /**
     * @test
     * @depends it_should_create_contact
     */
    public function it_should_update_contact(string $contactId)
    {
        $contactUpdateBag = new UpdateContactBag($contactId);
        $contactUpdateBag->phoneNumber = self::CONTACT_PHONE_NUMBER_2;

        $contact = $this->feature->updateContact($contactUpdateBag);

        $this->assertEquals(self::CONTACT_PHONE_NUMBER_2, $contact->phoneNumber);
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

    private static function cleanupContact(int $phoneNumber)
    {
        $feature = self::$smsapiService->contactsFeature();

        $contactFindBag = new FindContactsBag();
        $contactFindBag->phoneNumber = $phoneNumber;

        $foundContacts = $feature->findContacts($contactFindBag);

        if (count($foundContacts) > 0) {
            $contactDeleteBag = new DeleteContactBag($foundContacts[0]->id);
            $feature->deleteContact($contactDeleteBag);
        }
    }
}
