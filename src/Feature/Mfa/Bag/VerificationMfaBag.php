<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Mfa\Bag;

/**
 * @api
 */
#[\AllowDynamicProperties]
class VerificationMfaBag
{
    /**
     * @var string
     */
    public $phoneNumber;
    /**
     * @var string
     */
    public $code;

    public function __construct(string $code, string $phoneNumber)
    {
        $this->code = $code;
        $this->phoneNumber = $phoneNumber;
    }
}
