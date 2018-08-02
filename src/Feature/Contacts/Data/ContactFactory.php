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

    public function __construct(ContactGroupFactory $contactGroupFactory)
    {
        $this->contactGroupFactory = $contactGroupFactory;
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

        return $contact;
    }
}
