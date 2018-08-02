<?php
declare(strict_types=1);

namespace Smsapi\Client\Feature\Push\Data;

/**
 * @api
 */
class PushApp
{
    /** @var string */
    public $id;

    /** @var string */
    public $name;

    /** @var null|string */
    public $icon;
}
