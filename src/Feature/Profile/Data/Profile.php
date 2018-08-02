<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Profile\Data;

/**
 * @api
 */
class Profile
{

    /** @var string */
    public $name;

    /** @var string */
    public $username;

    /** @var string */
    public $email;

    /** @var string */
    public $phoneNumber;

    /** @var string */
    public $paymentType;

    /** @var string */
    public $userType;

    /** @var float|null */
    public $points;
}
