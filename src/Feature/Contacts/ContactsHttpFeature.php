<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Contacts;

use Fig\Http\Message\RequestMethodInterface;
use Smsapi\Client\Feature\Contacts\Fields\ContactsFieldsFeature;
use Smsapi\Client\Feature\Contacts\Fields\ContactsFieldsHttpFeature;
use Smsapi\Client\Feature\Data\DataFactoryProvider;
use Smsapi\Client\Infrastructure\Request\RestRequestBuilderFactory;
use Smsapi\Client\Infrastructure\RequestExecutor\RestRequestExecutor;
use Smsapi\Client\Feature\Contacts\Bag\CreateContactBag;
use Smsapi\Client\Feature\Contacts\Bag\DeleteContactBag;
use Smsapi\Client\Feature\Contacts\Bag\FindContactBag;
use Smsapi\Client\Feature\Contacts\Bag\FindContactsBag;
use Smsapi\Client\Feature\Contacts\Bag\UpdateContactBag;
use Smsapi\Client\Feature\Contacts\Data\Contact;
use Smsapi\Client\Feature\Contacts\Groups\ContactsGroupsFeature;
use Smsapi\Client\Feature\Contacts\Groups\ContactsGroupsHttpFeature;

/**
 * @internal
 */
class ContactsHttpFeature implements ContactsFeature
{
    /**
     * @var DataFactoryProvider
     */
    private $dataFactoryProvider;

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
        DataFactoryProvider $dataFactoryProvider
    ) {
        $this->requestExecutor = $restRequestExecutor;
        $this->dataFactoryProvider = $dataFactoryProvider;
        $this->requestBuilderFactory = $requestBuilderFactory;
    }

    public function findContacts(FindContactsBag $findContactsBag): array
    {
        if (isset($findContactsBag->groupId)) {
            $findContactsBag->groupId = implode(',', $findContactsBag->groupId);
        }

        $builder = $this->requestBuilderFactory->create();

        $request = $builder
            ->withMethod(RequestMethodInterface::METHOD_GET)
            ->withPath('contacts')
            ->withBuiltInParameters((array) $findContactsBag)
            ->get();

        $result = $this->requestExecutor->execute($request);

        return array_map(
            [$this->dataFactoryProvider->provideContactFactory(), 'createFromObject'],
            $result->collection
        );
    }

    public function findContact(FindContactBag $findContactBag): Contact
    {
        $builder = $this->requestBuilderFactory->create();

        $request = $builder
            ->withMethod(RequestMethodInterface::METHOD_GET)
            ->withPath(sprintf('contacts/%s', $findContactBag->contactId))
            ->get();

        $result = $this->requestExecutor->execute($request);

        return $this->dataFactoryProvider->provideContactFactory()->createFromObject($result);
    }

    public function createContact(CreateContactBag $createContactBag): Contact
    {
        $builder = $this->requestBuilderFactory->create();

        $request = $builder
            ->withMethod(RequestMethodInterface::METHOD_POST)
            ->withPath('contacts')
            ->withBuiltInParameters((array) $createContactBag)
            ->get();

        $result = $this->requestExecutor->execute($request);

        return $this->dataFactoryProvider->provideContactFactory()->createFromObject($result);
    }

    public function updateContact(UpdateContactBag $updateContactBag): Contact
    {
        $contactId = $updateContactBag->contactId;

        unset($updateContactBag->contactId);

        $builder = $this->requestBuilderFactory->create();

        $request = $builder
            ->withMethod(RequestMethodInterface::METHOD_PUT)
            ->withPath(sprintf('contacts/%s', $contactId))
            ->withBuiltInParameters((array) $updateContactBag)
            ->get();

        $result = $this->requestExecutor->execute($request);

        return $this->dataFactoryProvider->provideContactFactory()->createFromObject($result);
    }

    public function deleteContact(DeleteContactBag $deleteContactBag)
    {
        $builder = $this->requestBuilderFactory->create();

        $request = $builder
            ->withMethod(RequestMethodInterface::METHOD_DELETE)
            ->withPath(sprintf('contacts/%s', $deleteContactBag->contactId))
            ->get();

        $this->requestExecutor->execute($request);
    }

    public function groupsFeature(): ContactsGroupsFeature
    {
        return new ContactsGroupsHttpFeature(
            $this->requestExecutor,
            $this->requestBuilderFactory,
            $this->dataFactoryProvider
        );
    }

    public function fieldsFeature(): ContactsFieldsFeature
    {
        return new ContactsFieldsHttpFeature(
            $this->requestExecutor,
            $this->requestBuilderFactory,
            $this->dataFactoryProvider
        );
    }
}
