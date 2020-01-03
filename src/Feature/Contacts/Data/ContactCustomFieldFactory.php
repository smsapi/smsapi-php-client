<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Contacts\Data;

/**
 * @internal
 */
class ContactCustomFieldFactory
{
    public function createFromObjectProperty(string $propertyName, string $propertyValue): ContactCustomField
    {
        return new ContactCustomField($propertyName, $propertyValue);
    }
}
