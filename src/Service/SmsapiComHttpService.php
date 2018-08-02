<?php

declare(strict_types=1);

namespace Smsapi\Client\Service;

use Smsapi\Client\Feature\Data\DataFactoryProvider;
use Smsapi\Client\Feature\Profile\ProfileFeature;
use Smsapi\Client\Feature\Profile\ProfileHttpFeature;
use Smsapi\Client\Feature\Profile\SmsapiPlProfileFeature;
use Smsapi\Client\Feature\Profile\SmsapiPlProfileHttpFeature;
use Smsapi\Client\Infrastructure\RequestExecutor\RequestExecutorFactory;

/**
 * @internal
 */
class SmsapiComHttpService implements SmsapiComService
{
    use HttpDefaultFeatures;

    private $requestExecutorFactory;
    private $dataFactoryProvider;

    public function __construct(
        RequestExecutorFactory $requestExecutorFactory,
        DataFactoryProvider $dataFactoryProvider
    ) {
        $this->requestExecutorFactory = $requestExecutorFactory;
        $this->dataFactoryProvider = $dataFactoryProvider;
    }

    public function profileFeature(): ProfileFeature
    {
        return new ProfileHttpFeature(
            $this->requestExecutorFactory->createRestRequestExecutor(),
            $this->dataFactoryProvider
        );
    }
}
