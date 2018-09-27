<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Contacts\Groups\Members;

use Fig\Http\Message\RequestMethodInterface;
use Smsapi\Client\Feature\Contacts\Data\ContactFactory;
use Smsapi\Client\Infrastructure\Request\RequestBuilderFactory;
use Smsapi\Client\Infrastructure\Request\RestRequestBuilderFactory;
use Smsapi\Client\Infrastructure\RequestExecutor\RequestExecutor;
use Smsapi\Client\Feature\Contacts\Data\Contact;
use Smsapi\Client\Feature\Contacts\Groups\Members\Bag\AddContactToGroupByQueryBag;
use Smsapi\Client\Feature\Contacts\Groups\Members\Bag\FindContactInGroupBag;
use Smsapi\Client\Feature\Contacts\Groups\Members\Bag\MoveContactToGroupByQueryBag;
use Smsapi\Client\Feature\Contacts\Groups\Members\Bag\PinContactToGroupBag;
use Smsapi\Client\Feature\Contacts\Groups\Members\Bag\UnpinContactFromGroupBag;
use Smsapi\Client\Feature\Contacts\Groups\Members\Bag\UnpinContactFromGroupByQueryBag;
use Smsapi\Client\Infrastructure\RequestExecutor\RestRequestExecutor;
use Smsapi\Client\SmsapiClientException;

/**
 * @internal
 */
class ContactsGroupsMembersHttpFeature implements ContactsGroupsMembersFeature
{
    /**
     * @var ContactFactory
     */
    private $contactFactory;

    /**
     * @var RestRequestExecutor
     */
    private $requestExecutor;

    /**
     * @var RestRequestBuilderFactory
     */
    private $requestBuilderFactory;

    public function __construct(
        RestRequestExecutor $restRequestExecutor,
        RestRequestBuilderFactory $requestBuilderFactory,
        ContactFactory $contactFactory
    ) {
        $this->requestExecutor = $restRequestExecutor;
        $this->contactFactory = $contactFactory;
        $this->requestBuilderFactory = $requestBuilderFactory;
    }

    /**
     * @param AddContactToGroupByQueryBag $addContactToGroupByQueryBag
     * @throws SmsapiClientException
     */
    public function addContactToGroupByQuery(AddContactToGroupByQueryBag $addContactToGroupByQueryBag)
    {
        $groupId = $addContactToGroupByQueryBag->id;
        unset($addContactToGroupByQueryBag->id);

        $builder = $this->requestBuilderFactory->create();

        $request = $builder
            ->withMethod(RequestMethodInterface::METHOD_POST)
            ->withPath(sprintf('contacts/groups/%s/members', $groupId))
            ->withBuiltInParameters((array) $addContactToGroupByQueryBag)
            ->get();

        $this->requestExecutor->execute($request);
    }

    /**
     * @param FindContactInGroupBag $findContactInGroupBag
     * @return Contact
     * @throws SmsapiClientException
     */
    public function findContactInGroup(FindContactInGroupBag $findContactInGroupBag): Contact
    {
        $builder = $this->requestBuilderFactory->create();

        $request = $builder
            ->withMethod(RequestMethodInterface::METHOD_POST)
            ->withPath(sprintf(
                'contacts/groups/%s/members/%s',
                $findContactInGroupBag->groupId,
                $findContactInGroupBag->contactId
            ))
            ->get();

        $result = $this->requestExecutor->execute($request);

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

        $builder = $this->requestBuilderFactory->create();

        $request = $builder
            ->withMethod(RequestMethodInterface::METHOD_PUT)
            ->withPath(sprintf('contacts/groups/%s/members', $groupId))
            ->withBuiltInParameters((array) $moveContactToGroupByQueryBag)
            ->get();

        $this->requestExecutor->execute($request);
    }

    /**
     * @param PinContactToGroupBag $pinContactToGroupBag
     * @return Contact
     * @throws SmsapiClientException
     */
    public function pinContactToGroup(PinContactToGroupBag $pinContactToGroupBag): Contact
    {
        $builder = $this->requestBuilderFactory->create();

        $request = $builder
            ->withMethod(RequestMethodInterface::METHOD_PUT)
            ->withPath(sprintf(
                'contacts/groups/%s/members/%s',
                $pinContactToGroupBag->groupId,
                $pinContactToGroupBag->contactId
            ))
            ->get();

        $result = $this->requestExecutor->execute($request);

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

        $builder = $this->requestBuilderFactory->create();

        $request = $builder
            ->withMethod(RequestMethodInterface::METHOD_DELETE)
            ->withPath(sprintf('contacts/groups/%s/members', $groupId))
            ->withBuiltInParameters((array) $unpinContactFromGroupByQueryBag)
            ->get();

        $this->requestExecutor->execute($request);
    }

    /**
     * @param UnpinContactFromGroupBag $unpinContactFromGroupBag
     * @throws SmsapiClientException
     */
    public function unpinContactFromGroup(UnpinContactFromGroupBag $unpinContactFromGroupBag)
    {
        $builder = $this->requestBuilderFactory->create();

        $request = $builder
            ->withMethod(RequestMethodInterface::METHOD_DELETE)
            ->withPath(sprintf(
                'contacts/groups/%s/members/%s',
                $unpinContactFromGroupBag->groupId,
                $unpinContactFromGroupBag->contactId
            ))
            ->get();

        $this->requestExecutor->execute($request);
    }
}
