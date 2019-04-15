<?php
declare(strict_types=1);

namespace Smsapi\Client\Feature\Contacts;

use Smsapi\Client\Feature\Contacts\Bag\CreateContactBag;
use Smsapi\Client\Feature\Contacts\Bag\DeleteContactBag;
use Smsapi\Client\Feature\Contacts\Bag\FindContactBag;
use Smsapi\Client\Feature\Contacts\Bag\FindContactsBag;
use Smsapi\Client\Feature\Contacts\Bag\UpdateContactBag;
use Smsapi\Client\Feature\Contacts\Data\Contact;
use Smsapi\Client\Feature\Contacts\Fields\ContactsFieldsFeature;
use Smsapi\Client\Feature\Contacts\Groups\ContactsGroupsFeature;

/**
 * @api
 */
interface ContactsFeature
{
    /**
     * @return Contact[]
     */
    public function findContacts(FindContactsBag $findContactsBag = null): array;

    public function findContact(FindContactBag $findContactBag): Contact;

    public function createContact(CreateContactBag $createContactBag): Contact;

    public function updateContact(UpdateContactBag $updateContactBag): Contact;

    public function deleteContact(DeleteContactBag $deleteContactBag);

    public function deleteContacts();

    public function groupsFeature(): ContactsGroupsFeature;

    public function fieldsFeature(): ContactsFieldsFeature;
}
