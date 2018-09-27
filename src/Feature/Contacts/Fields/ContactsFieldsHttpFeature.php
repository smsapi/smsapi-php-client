<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Contacts\Fields;

use Fig\Http\Message\RequestMethodInterface;
use Smsapi\Client\Feature\Contacts\Fields\Bag\CreateContactFieldBag;
use Smsapi\Client\Feature\Contacts\Fields\Bag\DeleteContactFieldBag;
use Smsapi\Client\Feature\Contacts\Fields\Bag\FindContactFieldOptionsBag;
use Smsapi\Client\Feature\Contacts\Fields\Bag\UpdateContactFieldBag;
use Smsapi\Client\Feature\Contacts\Fields\Data\ContactField;
use Smsapi\Client\Feature\Data\DataFactoryProvider;
use Smsapi\Client\Infrastructure\Request\RequestBuilderFactory;
use Smsapi\Client\Infrastructure\Request\RestRequestBuilderFactory;
use Smsapi\Client\Infrastructure\RequestExecutor\RequestExecutor;
use Smsapi\Client\Infrastructure\RequestExecutor\RestRequestExecutor;

/**
 * @internal
 */
class ContactsFieldsHttpFeature implements ContactsFieldsFeature
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

    public function findFields(): array
    {
        $builder = $this->requestBuilderFactory->create();

        $request = $builder
            ->withMethod(RequestMethodInterface::METHOD_GET)
            ->withPath('contacts/fields')
            ->get();

        $result = $this->requestExecutor->execute($request);

        return array_map(
            [$this->dataFactoryProvider->provideContactFieldFactory(), 'createFromObject'],
            $result->collection
        );
    }

    public function createField(CreateContactFieldBag $createContactFieldBag): ContactField
    {
        $builder = $this->requestBuilderFactory->create();

        $request = $builder
            ->withMethod(RequestMethodInterface::METHOD_POST)
            ->withPath('contacts/fields')
            ->withBuiltInParameters((array) $createContactFieldBag)
            ->get();

        $result = $this->requestExecutor->execute($request);

        return $this->dataFactoryProvider->provideContactFieldFactory()->createFromObject($result);
    }

    public function updateField(UpdateContactFieldBag $updateContactFieldBag): ContactField
    {
        $fieldId = $updateContactFieldBag->fieldId;

        unset($updateContactFieldBag->fieldId);

        $builder = $this->requestBuilderFactory->create();

        $request = $builder
            ->withMethod(RequestMethodInterface::METHOD_PUT)
            ->withPath(sprintf('contacts/fields/%s', $fieldId))
            ->withBuiltInParameters((array) $updateContactFieldBag)
            ->get();

        $result = $this->requestExecutor->execute($request);

        return $this->dataFactoryProvider->provideContactFieldFactory()->createFromObject($result);
    }

    public function deleteField(DeleteContactFieldBag $deleteContactFieldBag)
    {
        $fieldId = $deleteContactFieldBag->fieldId;

        unset($deleteContactFieldBag->fieldId);

        $builder = $this->requestBuilderFactory->create();

        $request = $builder
            ->withMethod(RequestMethodInterface::METHOD_DELETE)
            ->withPath(sprintf('contacts/fields/%s', $fieldId))
            ->withBuiltInParameters((array) $deleteContactFieldBag)
            ->get();

        $this->requestExecutor->execute($request);
    }

    public function findFieldOptions(FindContactFieldOptionsBag $findContactFieldOptionsBag): array
    {
        $builder = $this->requestBuilderFactory->create();

        $request = $builder
            ->withMethod(RequestMethodInterface::METHOD_GET)
            ->withPath(sprintf('contacts/fields/%s/options', $findContactFieldOptionsBag->fieldId))
            ->get();

        $result = $this->requestExecutor->execute($request);

        return array_map(
            [$this->dataFactoryProvider->provideContactFieldOptionFactory(), 'createFromObject'],
            $result->collection
        );
    }
}
