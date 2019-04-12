<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Integration\Feature\Contacts\Groups\Members;

use Smsapi\Client\Feature\Contacts\Data\Contact;
use Smsapi\Client\Feature\Contacts\Data\ContactGroup;
use Smsapi\Client\Feature\Contacts\Groups\Members\Bag\AddContactToGroupByQueryBag;
use Smsapi\Client\Feature\Contacts\Groups\Members\Bag\FindContactInGroupBag;
use Smsapi\Client\Feature\Contacts\Groups\Members\Bag\MoveContactToGroupByQueryBag;
use Smsapi\Client\Feature\Contacts\Groups\Members\Bag\PinContactToGroupBag;
use Smsapi\Client\Feature\Contacts\Groups\Members\Bag\UnpinContactFromGroupBag;
use Smsapi\Client\Feature\Contacts\Groups\Members\Bag\UnpinContactFromGroupByQueryBag;
use Smsapi\Client\Feature\Contacts\Groups\Members\ContactsGroupsMembersFeature;
use Smsapi\Client\Infrastructure\ResponseMapper\ApiErrorException;
use Smsapi\Client\Tests\Helper\ContactsHelper;
use Smsapi\Client\Tests\SmsapiClientIntegrationTestCase;

class ContactsGroupsMembersFeatureTest extends SmsapiClientIntegrationTestCase
{

    /** @var ContactsGroupsMembersFeature */
    private $feature;

    /** @var ContactsHelper */
    private $helper;

    /** @var Contact */
    private $contact;

    /** @var ContactGroup */
    private $group;

    /**
     * @before
     */
    public function before()
    {
        $this->feature = self::$smsapiService->contactsFeature()->groupsFeature()->membersFeature();

        $this->helper = new ContactsHelper(self::$smsapiService->contactsFeature());
        $this->contact = $this->helper->createContact();
        $this->group = $this->helper->createGroup();
    }

    /**
     * @after
     */
    public function after()
    {
        $this->helper->deleteContact($this->contact->id);
        $this->helper->deleteGroup($this->group->id);
    }

    /**
     * @test
     */
    public function it_should_add_contact_to_group_by_query()
    {
        $groupToContactAddByQueryBag = new AddContactToGroupByQueryBag($this->group->id);
        $groupToContactAddByQueryBag->email = $this->contact->email;
        $findContactInGroupBag = new FindContactInGroupBag($this->contact->id, $this->group->id);

        $this->feature->addContactToGroupByQuery($groupToContactAddByQueryBag);
        $contactChecked = $this->waitForContactInGroup($findContactInGroupBag);

        $this->assertEquals($this->contact->id, $contactChecked->id);
    }

    /**
     * @test
     */
    public function it_should_check_if_contact_is_in_group()
    {
        $findContactInGroupBag = new FindContactInGroupBag($this->contact->id, $this->group->id);

        $this->helper->assignContactToGroup($this->contact->id, $this->group->id);
        $contactChecked = $this->waitForContactInGroup($findContactInGroupBag);

        $this->assertEquals($this->contact->id, $contactChecked->id);
    }

    /**
     * @test
     */
    public function it_should_move_contact_to_group_by_query()
    {
        $moveContactToGroupByQueryBag = new MoveContactToGroupByQueryBag($this->group->id);
        $moveContactToGroupByQueryBag->email = $this->contact->email;
        $findContactInGroupBag = new FindContactInGroupBag($this->contact->id, $this->group->id);

        $this->feature->moveContactToGroupByQuery($moveContactToGroupByQueryBag);
        $contactChecked = $this->waitForContactInGroup($findContactInGroupBag);

        $this->assertEquals($this->contact->id, $contactChecked->id);
    }

    /**
     * @test
     */
    public function it_should_pin_contact_to_group()
    {
        $pinContactToGroupBag = new PinContactToGroupBag($this->contact->id, $this->group->id);
        $findContactInGroupBag = new FindContactInGroupBag($this->contact->id, $this->group->id);

        $this->feature->pinContactToGroup($pinContactToGroupBag);
        $contactChecked = $this->waitForContactInGroup($findContactInGroupBag);

        $this->assertEquals($this->contact->id, $contactChecked->id);
    }


    /**
     * @test
     */
    public function it_should_unpin_contact_from_group_by_query()
    {
        $unpinContactFromGroupByQueryBag = new UnpinContactFromGroupByQueryBag($this->group->id);
        $unpinContactFromGroupByQueryBag->email = $this->contact->email;
        $findContactInGroupBag = new FindContactInGroupBag($this->contact->id, $this->group->id);

        $this->helper->assignContactToGroup($this->contact->id, $this->group->id);
        $this->feature->unpinContactFromGroupByQuery($unpinContactFromGroupByQueryBag);

        $this->waitForContactNotInGroup($findContactInGroupBag);
    }

    /**
     * @test
     */
    public function it_should_unpin_contact_from_group()
    {
        $unpinContactFromGroupBag = new UnpinContactFromGroupBag($this->contact->id, $this->group->id);
        $findContactInGroupBag = new FindContactInGroupBag($this->contact->id, $this->group->id);

        $this->helper->assignContactToGroup($this->contact->id, $this->group->id);
        $this->feature->unpinContactFromGroup($unpinContactFromGroupBag);

        $this->waitForContactNotInGroup($findContactInGroupBag);
    }

    public function waitForContactInGroup(FindContactInGroupBag $findContactInGroupBag): Contact
    {
        $sleepTime = 10000;
        $timeout = 100000;
        $contactInGroup = null;

        do {
            try {
                $contactInGroup = $this->feature->findContactInGroup($findContactInGroupBag);
                $timeout = 0;
            } catch (ApiErrorException $exception) {
                if ($exception->getError() !== 'contact_not_found') {
                    throw $exception;
                }
                $timeout -= $sleepTime;
                usleep($sleepTime);
            }
        } while ($timeout > 0);

        $this->assertNotNull($contactInGroup);

        return $contactInGroup;
    }

    public function waitForContactNotInGroup(FindContactInGroupBag $findContactInGroupBag)
    {
        $sleepTime = 10000;
        $timeout = 100000;
        $contactInGroup = null;

        do {
            try {
                $contactInGroup = $this->feature->findContactInGroup($findContactInGroupBag);
                $timeout -= $sleepTime;
                usleep($sleepTime);
            } catch (ApiErrorException $exception) {
                if ($exception->getError() !== 'contact_not_found') {
                    throw $exception;
                }
                $contactInGroup = null;
                $timeout = 0;
            }
        } while ($timeout > 0);

        $this->assertNull($contactInGroup);
    }
}
