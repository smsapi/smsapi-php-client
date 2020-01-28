<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Sms\Mfa\Data;

class Mfa
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $code;

    /**
     * @var string
     */
    public $phoneNumber;

    /**
     * @var string
     */
    public $from;
}
