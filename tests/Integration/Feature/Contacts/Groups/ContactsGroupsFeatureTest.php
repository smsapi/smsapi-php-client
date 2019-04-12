<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Integration\Feature\Contacts\Groups;

use Smsapi\Client\Feature\Contacts\Groups\Bag\AssignContactToGroupBag;
use Smsapi\Client\Feature\Contacts\Groups\Bag\CreateGroupBag;
use Smsapi\Client\Feature\Contacts\Groups\Bag\DeleteGroupBag;
use Smsapi\Client\Feature\Contacts\Groups\Bag\FindContactGroupBag;
use Smsapi\Client\Feature\Contacts\Groups\Bag\FindContactGroupsBag;
use Smsapi\Client\Feature\Contacts\Groups\Bag\FindGroupBag;
use Smsapi\Client\Feature\Contacts\Groups\Bag\UnpinContactFromGroupBag;
use Smsapi\Client\Feature\Contacts\Groups\Bag\UpdateGroupBag;
use Smsapi\Client\Feature\Contacts\Groups\ContactsGroupsFeature;
use Smsapi\Client\Infrastructure\ResponseMapper\ApiErrorException;
use Smsapi\Client\Tests\Helper\ContactsHelper;
use Smsapi\Client\Tests\SmsapiClientIntegrationTestCase;

class ContactsGroupsFeatureTest extends SmsapiClientIntegrationTestCase
{

    const GROUP_NAME_1 = 'test_group_1';
    const GROUP_NAME_2 = 'test_group_2';

    /** @var ContactsGroupsFeature */
    private $feature;

    /** @var ContactsHelper */
    private $helper;

    /**
     * @before
     */
    public function before()
    {
        $this->feature = self::$smsapiService->contactsFeature()->groupsFeature();
        $this->helper = new ContactsHelper(self::$smsapiService->contactsFeature());
    }

    /**
     * @test
     */
    public function it_should_create_group(): string
    {
        $groupCreateBag = new CreateGroupBag(self::GROUP_NAME_1);

        $group = $this->feature->createGroup($groupCreateBag);

        $this->assertEquals(self::GROUP_NAME_1, $group->name);

        return $group->id;
    }

    /**
     * @test
     * @depends it_should_create_group
     */
    public function it_should_update_group(string $groupId)
    {
        $groupUpdateBag = new UpdateGroupBag($groupId, self::GROUP_NAME_2);

        $group = $this->feature->updateGroup($groupUpdateBag);

        $this->assertEquals(self::GROUP_NAME_2, $group->name);
    }

    /**
     * @test
     * @depends it_should_create_group
     */
    public function it_should_find_group(string $groupId)
    {
        $groupFindBag = new FindGroupBag($groupId);

        $group = $this->feature->findGroup($groupFindBag);

        $this->assertEquals($groupId, $group->id);
    }

    /**
     * @test
     * @depends it_should_create_group
     */
    public function it_should_assign_contact_to_group(string $groupId): string
    {
        $contact = $this->helper->createContact();
        $contactToGroupAssignBag = new AssignContactToGroupBag($contact->id, $groupId);

        $groups = $this->feature->assignContactToGroup($contactToGroupAssignBag);

        $this->assertEquals($groupId, $groups[0]->id);

        return $contact->id;
    }

    /**
     * @test
     * @depends it_should_create_group
     * @depends it_should_assign_contact_to_group
     */
    public function it_should_find_contact_group(string $groupId, string $contactId)
    {
        $contactGroupFindBag = new FindContactGroupBag($contactId, $groupId);

        $group = $this->feature->findContactGroup($contactGroupFindBag);

        $this->assertEquals($groupId, $group->id);
    }

    /**
     * @test
     * @depends it_should_create_group
     * @depends it_should_assign_contact_to_group
     */
    public function it_should_find_contact_groups(string $groupId, string $contactId)
    {
        $contactGroupsFindBag = new FindContactGroupsBag($contactId);

        $groups = $this->feature->findContactGroups($contactGroupsFindBag);

        $this->assertEquals($groupId, $groups[0]->id);
    }

    /**
     * @test
     * @depends it_should_create_group
     * @depends it_should_assign_contact_to_group
     */
    public function it_should_unpin_contact_from_group(string $groupId, string $contactId)
    {
        $contactFromGroupUnpinBag = new UnpinContactFromGroupBag($contactId, $groupId);
        $contactGroupFindBag = new FindContactGroupBag($contactId, $groupId);

        $this->expectException(ApiErrorException::class);
        $this->expectExceptionMessage('Group not found');

        $this->feature->unpinContactFromGroup($contactFromGroupUnpinBag);
        $this->feature->findContactGroup($contactGroupFindBag);

        // cleanup
        $this->helper->deleteContact($contactId);
    }

    /**
     * @test
     * @depends it_should_create_group
     */
    public function it_should_find_all_groups()
    {
        $groups = $this->feature->findGroups();

        $this->assertGreaterThanOrEqual(1, count($groups));
    }

    /**
     * @test
     * @depends it_should_create_group
     */
    public function it_should_delete_group(string $groupId)
    {
        $groupDeleteBag = new DeleteGroupBag($groupId);
        $groupFindBag = new FindGroupBag($groupId);

        $this->expectException(ApiErrorException::class);
        $this->expectExceptionMessage('Group not found');

        $this->feature->deleteGroup($groupDeleteBag);
        $this->feature->findGroup($groupFindBag);
    }
}
