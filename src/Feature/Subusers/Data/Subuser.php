<?php
declare(strict_types=1);

namespace Smsapi\Client\Feature\Subusers\Data;

use Smsapi\Client\Feature\Data\Points;

/**
 * @api
 */
class Subuser
{
    /** @var string */
    public $id;

    /** @var string */
    public $username;

    /** @var Points */
    public $points;

    /** @var bool */
    public $active;

    /** @var string */
    public $description;
}
