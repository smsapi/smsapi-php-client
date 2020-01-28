<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Sms\Mfa;

use Smsapi\Client\Feature\Sms\Mfa\Bag\CreateMfaBag;
use Smsapi\Client\Feature\Sms\Mfa\Bag\VerificationMfaBag;
use Smsapi\Client\Feature\Sms\Mfa\Data\Mfa;

/**
 * @api
 */
interface MfaFeature
{
    public function createMfa(CreateMfaBag $createMfaBag): Mfa;

    public function verificationMfa(VerificationMfaBag $verificationMfaBag);
}
