<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Sms\Mfa;

use Smsapi\Client\Feature\Sms\Mfa\Bag\CreateMfaBag;
use Smsapi\Client\Feature\Sms\Mfa\Data\Mfa;
use Smsapi\Client\Feature\Sms\Mfa\Data\MfaFactory;
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
     * @param CreateMfaBag $createMfaBag
     * @return Mfa
     * @throws SmsapiClientException
     */
    public function createMfa(CreateMfaBag $createMfaBag): Mfa
    {
        $result = $this->restRequestExecutor->create('mfa/codes', (array)$createMfaBag);
        return $this->mfaFactory->createFromObject($result);
    }
}
