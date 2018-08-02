<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Profile\Data;

use DateTimeInterface;

/**
 * @api
 */
class ProfilePrice
{

    /** @var string */
    public $type;

    /** @var Money */
    public $price;

    /** @var ProfilePriceCountry */
    public $country;

    /** @var ProfilePriceNetwork */
    public $network;

    /** @var DateTimeInterface|null */
    public $changedAt;
}
