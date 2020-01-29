<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Mfa\Bag;

/**
 * @api
 * @property string $code
 * @property string $phone_number
 */
class VerificationMfaBag
{
    /**
     * @var string
     */
    public $phone_number;
    /**
     * @var string
     */
    public $code;

    /**
     * @param string $code
     * @param string $phone_number
     */
    public function __construct(string $code, string $phone_number)
    {
        $this->code = $code;
        $this->phone_number = $phone_number;
    }
}
