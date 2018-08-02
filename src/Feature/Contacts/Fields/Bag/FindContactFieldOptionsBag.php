<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Contacts\Fields\Bag;

/**
 * @api
 */
class FindContactFieldOptionsBag
{

    /** @var string */
    public $fieldId;

    public function __construct(string $fieldId)
    {
        $this->fieldId = $fieldId;
    }
}
