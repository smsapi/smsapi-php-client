<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Helper;

use Smsapi\Client\Feature\Contacts\Bag\CreateContactBag;
use Smsapi\Client\Feature\Contacts\Bag\DeleteContactBag;
use Smsapi\Client\Feature\Contacts\ContactsFeature;
use Smsapi\Client\Feature\Contacts\Data\Contact;
use Smsapi\Client\Feature\Contacts\Data\ContactGroup;
use Smsapi\Client\Feature\Contacts\Groups\Bag\AssignContactToGroupBag;
use Smsapi\Client\Feature\Contacts\Groups\Bag\CreateGroupBag;
use Smsapi\Client\Feature\Contacts\Groups\Bag\DeleteGroupBag;

class ContactsHelper
{

    /** @var ContactsFeature */
    private $feature;

    public function __construct(ContactsFeature $feature)
    {
        $this->feature = $feature;
    }

    public function createContact(): Contact
    {
        $contactCreateBag = new CreateContactBag();
        $contactCreateBag->email = uniqid('test_') . '@example.com';
        return $this->feature->createContact($contactCreateBag);
    }

    public function deleteContact(string $contactId)
    {
        $contactDeleteBag = new DeleteContactBag($contactId);
        $this->feature->deleteContact($contactDeleteBag);
    }

    public function createGroup(): ContactGroup
    {
        $groupCreateBag = new CreateGroupBag(uniqid('test_group_'));
        return $this->feature->groupsFeature()->createGroup($groupCreateBag);
    }

    public function deleteGroup(string $groupId)
    {
        $deleteGroupBag = new DeleteGroupBag($groupId);
        $deleteGroupBag->deleteContacts = true;
        $this->feature->groupsFeature()->deleteGroup($deleteGroupBag);

        usleep(60000);
    }

    public function assignContactToGroup(string $contactId, string $groupId)
    {
        $contactToGroupAssignBag = new AssignContactToGroupBag($contactId, $groupId);
        $this->feature->groupsFeature()->assignContactToGroup($contactToGroupAssignBag);
    }
}
