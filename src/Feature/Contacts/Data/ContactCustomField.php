<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Contacts\Data;

/**
 * @api
 */
class ContactCustomField
{
    public $name;

    public $value;

    public function __construct(string $name, string $value)
    {
        $this->name = $name;
        $this->value = $value;
    }
}
