<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Contacts\Fields;

use Smsapi\Client\Feature\Contacts\Fields\Bag\CreateContactFieldBag;
use Smsapi\Client\Feature\Contacts\Fields\Bag\DeleteContactFieldBag;
use Smsapi\Client\Feature\Contacts\Fields\Bag\FindContactFieldOptionsBag;
use Smsapi\Client\Feature\Contacts\Fields\Bag\UpdateContactFieldBag;
use Smsapi\Client\Feature\Contacts\Fields\Data\ContactField;
use Smsapi\Client\Feature\Data\DataFactoryProvider;
use Smsapi\Client\Infrastructure\RequestExecutor\RestRequestExecutor;

/**
 * @internal
 */
class ContactsFieldsHttpFeature implements ContactsFieldsFeature
{
    private $restRequestExecutor;
    private $dataFactoryProvider;

    public function __construct(RestRequestExecutor $restRequestExecutor, DataFactoryProvider $dataFactoryProvider)
    {
        $this->restRequestExecutor = $restRequestExecutor;
        $this->dataFactoryProvider = $dataFactoryProvider;
    }

    public function findFields(): array
    {
        $result = $this->restRequestExecutor->read('contacts/fields', []);

        return array_map(
            [$this->dataFactoryProvider->provideContactFieldFactory(), 'createFromObject'],
            $result->collection
        );
    }

    public function createField(CreateContactFieldBag $createContactFieldBag): ContactField
    {
        $result = $this->restRequestExecutor->create('contacts/fields', (array)$createContactFieldBag);

        return $this->dataFactoryProvider->provideContactFieldFactory()->createFromObject($result);
    }

    public function updateField(UpdateContactFieldBag $updateContactFieldBag): ContactField
    {
        $fieldId = $updateContactFieldBag->fieldId;

        unset($updateContactFieldBag->fieldId);

        $result = $this->restRequestExecutor->update(
            'contacts/fields/' . $fieldId,
            (array)$updateContactFieldBag
        );

        return $this->dataFactoryProvider->provideContactFieldFactory()->createFromObject($result);
    }

    public function deleteField(DeleteContactFieldBag $deleteContactFieldBag)
    {
        $fieldId = $deleteContactFieldBag->fieldId;

        unset($deleteContactFieldBag->fieldId);

        $this->restRequestExecutor->delete('contacts/fields/' . $fieldId, (array)$deleteContactFieldBag);
    }

    public function findFieldOptions(FindContactFieldOptionsBag $findContactFieldOptionsBag): array
    {
        $endpointPath = 'contacts/fields/' . $findContactFieldOptionsBag->fieldId . '/options';
        $result = $this->restRequestExecutor->read($endpointPath, []);

        return array_map(
            [$this->dataFactoryProvider->provideContactFieldOptionFactory(), 'createFromObject'],
            $result->collection
        );
    }
}
