<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Contacts\Fields\Bag;

/**
 * @api
 * @property string $type
 */
#[\AllowDynamicProperties]
class CreateContactFieldBag
{

    /** @var string */
    public $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}
