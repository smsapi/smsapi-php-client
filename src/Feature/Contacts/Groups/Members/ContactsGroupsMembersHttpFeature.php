<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Contacts\Groups\Members;

use Smsapi\Client\Infrastructure\RequestExecutor\RestRequestExecutor;
use Smsapi\Client\Feature\Contacts\Data\Contact;
use Smsapi\Client\Feature\Contacts\Data\ContactFactory;
use Smsapi\Client\Feature\Contacts\Groups\Members\Bag\AddContactToGroupByQueryBag;
use Smsapi\Client\Feature\Contacts\Groups\Members\Bag\FindContactInGroupBag;
use Smsapi\Client\Feature\Contacts\Groups\Members\Bag\MoveContactToGroupByQueryBag;
use Smsapi\Client\Feature\Contacts\Groups\Members\Bag\PinContactToGroupBag;
use Smsapi\Client\Feature\Contacts\Groups\Members\Bag\UnpinContactFromGroupBag;
use Smsapi\Client\Feature\Contacts\Groups\Members\Bag\UnpinContactFromGroupByQueryBag;
use Smsapi\Client\SmsapiClientException;

/**
 * @internal
 */
class ContactsGroupsMembersHttpFeature implements ContactsGroupsMembersFeature
{

    /** @var RestRequestExecutor */
    private $restRequestExecutor;

    /** @var ContactFactory */
    private $contactFactory;

    public function __construct(RestRequestExecutor $restRequestExecutor, ContactFactory $contactFactory)
    {
        $this->restRequestExecutor = $restRequestExecutor;
        $this->contactFactory = $contactFactory;
    }

    /**
     * @param AddContactToGroupByQueryBag $addContactToGroupByQueryBag
     * @throws SmsapiClientException
     */
    public function addContactToGroupByQuery(AddContactToGroupByQueryBag $addContactToGroupByQueryBag)
    {
        $groupId = $addContactToGroupByQueryBag->id;
        unset($addContactToGroupByQueryBag->id);
        $this->restRequestExecutor->create(
            'contacts/groups/' . $groupId . '/members',
            (array)$addContactToGroupByQueryBag
        );
    }

    /**
     * @param FindContactInGroupBag $findContactInGroupBag
     * @return Contact
     * @throws SmsapiClientException
     */
    public function findContactInGroup(FindContactInGroupBag $findContactInGroupBag): Contact
    {
        $result = $this->restRequestExecutor->read(
            sprintf(
                'contacts/groups/%s/members/%s',
                $findContactInGroupBag->groupId,
                $findContactInGroupBag->contactId
            ),
            []
        );
        return $this->contactFactory->createFromObject($result);
    }

    /**
     * @param MoveContactToGroupByQueryBag $moveContactToGroupByQueryBag
     * @throws SmsapiClientException
     */
    public function moveContactToGroupByQuery(MoveContactToGroupByQueryBag $moveContactToGroupByQueryBag)
    {
        $groupId = $moveContactToGroupByQueryBag->id;
        unset($moveContactToGroupByQueryBag->id);
        $this->restRequestExecutor->update(
            'contacts/groups/' . $groupId . '/members',
            (array)$moveContactToGroupByQueryBag
        );
    }

    /**
     * @param PinContactToGroupBag $pinContactToGroupBag
     * @return Contact
     * @throws SmsapiClientException
     */
    public function pinContactToGroup(PinContactToGroupBag $pinContactToGroupBag): Contact
    {
        $result = $this->restRequestExecutor->update(
            'contacts/groups/' . $pinContactToGroupBag->groupId . '/members/' . $pinContactToGroupBag->contactId,
            []
        );
        return $this->contactFactory->createFromObject($result);
    }

    /**
     * @param UnpinContactFromGroupByQueryBag $unpinContactFromGroupByQueryBag
     * @throws SmsapiClientException
     */
    public function unpinContactFromGroupByQuery(UnpinContactFromGroupByQueryBag $unpinContactFromGroupByQueryBag)
    {
        $groupId = $unpinContactFromGroupByQueryBag->id;
        unset($unpinContactFromGroupByQueryBag->id);
        $this->restRequestExecutor->delete(
            'contacts/groups/' . $groupId . '/members',
            (array)$unpinContactFromGroupByQueryBag
        );
    }

    /**
     * @param UnpinContactFromGroupBag $unpinContactFromGroupBag
     * @throws SmsapiClientException
     */
    public function unpinContactFromGroup(UnpinContactFromGroupBag $unpinContactFromGroupBag)
    {
        $this->restRequestExecutor->delete(
            sprintf(
                'contacts/groups/%s/members/%s',
                $unpinContactFromGroupBag->groupId,
                $unpinContactFromGroupBag->contactId
            ),
            []
        );
    }
}
