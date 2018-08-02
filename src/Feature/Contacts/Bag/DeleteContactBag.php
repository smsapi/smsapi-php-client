<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Contacts\Bag;

/**
 * @api
 */
class DeleteContactBag
{

    /** @var string */
    public $contactId;

    public function __construct(string $contactId)
    {
        $this->contactId = $contactId;
    }
}
