<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Contacts\Fields;

use Smsapi\Client\Feature\Contacts\Fields\Bag\CreateContactFieldBag;
use Smsapi\Client\Feature\Contacts\Fields\Bag\DeleteContactFieldBag;
use Smsapi\Client\Feature\Contacts\Fields\Bag\FindContactFieldOptionsBag;
use Smsapi\Client\Feature\Contacts\Fields\Bag\UpdateContactFieldBag;
use Smsapi\Client\Feature\Contacts\Fields\Data\ContactField;
use Smsapi\Client\Feature\Contacts\Fields\Data\ContactFieldOption;

/**
 * @api
 */
interface ContactsFieldsFeature
{

    /**
     * @return ContactField[]
     */
    public function findFields(): array;

    /**
     * @param CreateContactFieldBag $createContactFieldBag
     * @return ContactField
     */
    public function createField(CreateContactFieldBag $createContactFieldBag): ContactField;

    /**
     * @param UpdateContactFieldBag $updateContactFieldBag
     * @return ContactField
     */
    public function updateField(UpdateContactFieldBag $updateContactFieldBag): ContactField;

    /**
     * @param DeleteContactFieldBag $deleteContactFieldBag
     */
    public function deleteField(DeleteContactFieldBag $deleteContactFieldBag);

    /**
     * @param FindContactFieldOptionsBag $findContactFieldOptionsBag
     * @return ContactFieldOption[]
     */
    public function findFieldOptions(FindContactFieldOptionsBag $findContactFieldOptionsBag): array;
}
