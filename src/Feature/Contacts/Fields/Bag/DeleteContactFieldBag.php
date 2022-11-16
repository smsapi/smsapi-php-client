<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Contacts\Fields\Bag;

/**
 * @api
 */
#[\AllowDynamicProperties]
class DeleteContactFieldBag
{

    /** @var string */
    public $fieldId;

    public function __construct(string $fieldId)
    {
        $this->fieldId = $fieldId;
    }
}
