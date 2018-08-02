<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Assert;

use PHPUnit\Framework\Assert;
use Smsapi\Client\Feature\Contacts\Fields\Data\ContactField;

class ContactFieldsAssert extends Assert
{

    /**
     * @param string $fieldId
     * @param ContactField[] $fields
     */
    public function assertFieldIdInCollection(string $fieldId, array $fields)
    {
        $this->assertTrue($this->isFieldIdInCollection($fieldId, $fields));
    }

    /**
     * @param string $fieldId
     * @param ContactField[] $fields
     */
    public function assertFieldIdNotInCollection(string $fieldId, array $fields)
    {
        $this->assertFalse($this->isFieldIdInCollection($fieldId, $fields));
    }

    /**
     * @param string $fieldId
     * @param ContactField[] $fields
     * @return bool
     */
    private function isFieldIdInCollection(string $fieldId, array $fields): bool
    {
        return in_array($fieldId, array_column($fields, 'id'));
    }
}
