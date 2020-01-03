<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Assert;

use PHPUnit\Framework\Assert;
use Smsapi\Client\Feature\Contacts\Data\Contact;
use Smsapi\Client\Feature\Contacts\Fields\Data\ContactField;

class ContactCustomFieldAssert
{
    private $contact;

    private $assert;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
        $this->assert = new class extends Assert {};
    }

    public function assertHasCustomFieldWithValue(ContactField $expectedCustomField, string $expectedValue)
    {
        $this->assert->assertTrue($this->hasContactCustomFieldSet($expectedCustomField, $expectedValue));
    }

    private function hasContactCustomFieldSet(ContactField $expectedCustomField, string $expectedValue): bool
    {
        $contactHasCustomFieldSet = false;
        foreach ($this->contact->customFields as $customField) {
            if ($customField->name === $expectedCustomField->name && $customField->value === $expectedValue) {
                $contactHasCustomFieldSet = true;
                break;
            }
        }
        return $contactHasCustomFieldSet;
    }
}
