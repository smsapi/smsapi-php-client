<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Vms\Data;

use DateTimeInterface;

/**
 * @api
 */
class Vms
{

    /** @var string */
    public $id;

    /** @var float */
    public $points;

    /** @var string */
    public $number;

    /** @var DateTimeInterface */
    public $dateSent;

    /** @var string */
    public $status;
}
