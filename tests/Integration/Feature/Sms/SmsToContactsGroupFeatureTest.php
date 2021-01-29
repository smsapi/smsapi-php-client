<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Integration\Feature\Sms;

use DateTime;
use Smsapi\Client\Feature\Contacts\Bag\CreateContactBag;
use Smsapi\Client\Feature\Contacts\Data\Contact;
use Smsapi\Client\Feature\Contacts\Data\ContactGroup;
use Smsapi\Client\Feature\Contacts\Groups\Bag\AssignContactToGroupBag;
use Smsapi\Client\Feature\Contacts\Groups\Bag\CreateGroupBag;
use Smsapi\Client\Feature\Sms\Bag\ScheduleSmsToGroupBag;
use Smsapi\Client\Feature\Sms\Bag\SendSmsToGroupBag;
use Smsapi\Client\Tests\Fixture\PhoneNumberFixture;
use Smsapi\Client\Tests\Helper\ContactsHelper;
use Smsapi\Client\Tests\SmsapiClientIntegrationTestCase;

class SmsToContactsGroupFeatureTest extends SmsapiClientIntegrationTestCase
{
    /** @var string */
    private $phoneNumber;

    /** @var Contact */
    private $contact;

    /** @var ContactGroup */
    private $contactGroup;

    /**
     * @before
     */
    public function createContacts()
    {
        $this->phoneNumber = PhoneNumberFixture::anyValidMobile();

        $createContactBag = new CreateContactBag();
        $createContactBag->phoneNumber = $this->phoneNumber;
        $this->contact = self::$smsapiService->contactsFeature()->createContact($createContactBag);

        $createGroupBag = new CreateGroupBag(uniqid('some group '));
        $this->contactGroup = self::$smsapiService->contactsFeature()->groupsFeature()->createGroup($createGroupBag);

        $assignContactToGroupBag = new AssignContactToGroupBag($this->contact->id, $this->contactGroup->id);
        self::$smsapiService->contactsFeature()->groupsFeature()->assignContactToGroup($assignContactToGroupBag);
    }

    /**
     * @after
     */
    public function removeContacts()
    {
        $contactsHelper = new ContactsHelper(self::$smsapiService->contactsFeature());
        $contactsHelper->deleteContact($this->contact->id);
        $contactsHelper->deleteGroup($this->contactGroup->id);
    }

    /**
     * @test
     */
    public function it_should_send_sms_to_group()
    {
        $smsFeature = self::$smsapiService->smsFeature();
        $sendSmsToGroup = SendSmsToGroupBag::withMessage($this->contactGroup->name, 'some message');
        $sendSmsToGroup->test = true;

        $result = $smsFeature->sendSmsToGroup($sendSmsToGroup);

        $this->assertEquals($this->phoneNumber, $result[0]->number);
    }

    /**
     * @test
     */
    public function it_should_send_flash_sms_to_group()
    {
        $smsFeature = self::$smsapiService->smsFeature();
        $sendFlashSmsToGroup = SendSmsToGroupBag::withMessage($this->contactGroup->name, 'some message');
        $sendFlashSmsToGroup->test = true;

        $result = $smsFeature->sendFlashSmsToGroup($sendFlashSmsToGroup);

        $this->assertEquals($this->phoneNumber, $result[0]->number);
    }

    /**
     * @test
     */
    public function it_should_schedule_sms_to_group()
    {
        $someDate = new DateTime('+1 day noon');
        $smsFeature = self::$smsapiService->smsFeature();
        $scheduleSmsToGroup = ScheduleSmsToGroupBag::withMessage(
            $someDate,
            $this->contactGroup->name,
            'some message'
        );
        $scheduleSmsToGroup->test = true;

        $result = $smsFeature->scheduleSmsToGroup($scheduleSmsToGroup);

        $this->assertEquals($someDate, $result[0]->dateSent);
        $this->assertEquals($this->phoneNumber, $result[0]->number);
    }

    /**
     * @test
     */
    public function it_should_schedule_flash_sms_to_group()
    {
        $someDate = new DateTime('+1 day noon');
        $smsFeature = self::$smsapiService->smsFeature();
        $scheduleFlashSmsToGroup = ScheduleSmsToGroupBag::withMessage(
            $someDate,
            $this->contactGroup->name,
            'some message'
        );
        $scheduleFlashSmsToGroup->test = true;

        $result = $smsFeature->scheduleFlashSmsToGroup($scheduleFlashSmsToGroup);

        $this->assertEquals($someDate, $result[0]->dateSent);
        $this->assertEquals($this->phoneNumber, $result[0]->number);
    }
}
