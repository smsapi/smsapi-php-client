<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Mfa;

use Smsapi\Client\Feature\Mfa\Bag\CreateMfaBag;
use Smsapi\Client\Feature\Mfa\Bag\VerificationMfaBag;
use Smsapi\Client\Feature\Mfa\Data\Mfa;

/**
 * @api
 */
interface MfaFeature
{
    public function generateMfa(CreateMfaBag $createMfaBag): Mfa;

    public function verifyMfa(VerificationMfaBag $verificationMfaBag);
}
