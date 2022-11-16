<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Contacts\Groups\Bag;

/**
 * @api
 * @property string $description
 * @property string $idx
 * @property integer $contactExpireAfter
 */
#[\AllowDynamicProperties]
class CreateGroupBag
{

    /** @var string */
    public $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}
