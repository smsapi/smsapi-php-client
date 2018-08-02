<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Contacts\Fields\Data;

use stdClass;

/**
 * @internal
 */
class ContactFieldOptionFactory
{
    public function createFromObject(stdClass $object): ContactFieldOption
    {
        $contactFieldOption = new ContactFieldOption();
        $contactFieldOption->name = $object->name;
        $contactFieldOption->value = $object->value;

        return $contactFieldOption;
    }
}
