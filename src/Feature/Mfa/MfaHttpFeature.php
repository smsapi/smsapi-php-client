<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Mfa;

use Smsapi\Client\Feature\Mfa\Bag\CreateMfaBag;
use Smsapi\Client\Feature\Mfa\Bag\VerificationMfaBag;
use Smsapi\Client\Feature\Mfa\Data\Mfa;
use Smsapi\Client\Feature\Mfa\Data\MfaFactory;
use Smsapi\Client\Infrastructure\RequestExecutor\RestRequestExecutor;
use Smsapi\Client\SmsapiClientException;

/**
 * @internal
 */
class MfaHttpFeature implements MfaFeature
{
    private $restRequestExecutor;
    private $mfaFactory;

    public function __construct(RestRequestExecutor $restRequestExecutor, MfaFactory $mfaFactory)
    {
        $this->restRequestExecutor = $restRequestExecutor;
        $this->mfaFactory = $mfaFactory;
    }

    /**
     * @throws SmsapiClientException
     */
    public function generateMfa(CreateMfaBag $createMfaBag): Mfa
    {
        $result = $this->restRequestExecutor->create('mfa/codes', (array)$createMfaBag);
        return $this->mfaFactory->createFromObject($result);
    }

    /**
     * @throws SmsapiClientException
     */
    public function verifyMfa(VerificationMfaBag $verificationMfaBag)
    {
        $this->restRequestExecutor->create('mfa/codes/verifications', (array)$verificationMfaBag);
    }
}
