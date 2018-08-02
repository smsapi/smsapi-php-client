<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Profile;

use Smsapi\Client\Feature\Data\DataFactoryProvider;
use Smsapi\Client\Feature\Profile\Data\Profile;
use Smsapi\Client\Infrastructure\RequestExecutor\RestRequestExecutor;
use Smsapi\Client\SmsapiClientException;

/**
 * @internal
 */
trait ProfileDefaultHttpFeatures
{
    /** @var RestRequestExecutor */
    private $restRequestExecutor;

    /** @var DataFactoryProvider */
    private $dataFactoryProvider;

    /**
     * @return Profile
     * @throws SmsapiClientException
     */
    public function findProfile(): Profile
    {
        return $this->dataFactoryProvider
            ->provideProfileFactory()
            ->createFromObject($this->restRequestExecutor->read('profile', []));
    }
}
