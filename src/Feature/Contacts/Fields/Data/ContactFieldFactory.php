<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Contacts\Fields\Data;

use stdClass;

/**
 * @internal
 */
class ContactFieldFactory
{
    public function createFromObject(stdClass $object): ContactField
    {
        $contactField = new ContactField();
        $contactField->id = $object->id;
        $contactField->name = $object->name;
        $contactField->type = $object->type;

        return $contactField;
    }
}
