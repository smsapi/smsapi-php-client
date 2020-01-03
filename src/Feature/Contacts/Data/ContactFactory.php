<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Contacts\Data;

use DateTime;
use stdClass;

/**
 * @internal
 */
class ContactFactory
{
    private $contactGroupFactory;

    private $contactCustomFieldFactory;

    public function __construct(ContactGroupFactory $contactGroupFactory, ContactCustomFieldFactory $contactCustomFieldsFactory)
    {
        $this->contactGroupFactory = $contactGroupFactory;
        $this->contactCustomFieldFactory = $contactCustomFieldsFactory;
    }

    public function createFromObject(stdClass $object): Contact
    {
        $contact = new Contact();
        $contact->id = $object->id;
        $contact->dateCreated = new DateTime($object->date_created);
        $contact->dateUpdated = new DateTime($object->date_updated);
        $contact->gender = $object->gender;

        if (isset($object->email)) {
            $contact->email = $object->email;
        }

        if (isset($object->phone_number)) {
            $contact->phoneNumber = $object->phone_number;
        }

        if (isset($object->country)) {
            $contact->country = $object->country;
        }

        $contact->groups = array_map(
            [$this->contactGroupFactory, 'createFromObjectWithoutPermissions'],
            $object->groups
        );

        $objectCustomFieldsProperties = array_filter(get_object_vars($object), [$this, 'isCustomFieldProperty'], ARRAY_FILTER_USE_KEY);
        $contact->customFields = array_map(
            [$this->contactCustomFieldFactory, 'createFromObjectProperty'],
            array_keys($objectCustomFieldsProperties), $objectCustomFieldsProperties
        );

        return $contact;
    }

    public function isCustomFieldProperty(string $propertyName): bool
    {
        return !in_array($propertyName, [
            'id', 'date_created', 'date_updated', 'gender', 'email', 'phone_number', 'country', 'groups'
        ]);
    }
}
