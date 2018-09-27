<?php

declare(strict_types=1);

namespace Smsapi\Client\Service;

use Smsapi\Client\Feature\Data\DataFactoryProvider;
use Smsapi\Client\Feature\Profile\ProfileFeature;
use Smsapi\Client\Feature\Profile\ProfileHttpFeature;
use Smsapi\Client\Infrastructure\Request\LegacyRequestBuilderFactory;
use Smsapi\Client\Infrastructure\Request\RestRequestBuilderFactory;
use Smsapi\Client\Infrastructure\RequestExecutor\RequestExecutorFactory;

/**
 * @internal
 */
class SmsapiComHttpService implements SmsapiComService
{
    use HttpDefaultFeatures;

    public function __construct(
        RequestExecutorFactory $requestExecutorFactory,
        RestRequestBuilderFactory $restRequestBuilderFactory,
        LegacyRequestBuilderFactory $legacyRequestBuilderFactory,
        DataFactoryProvider $dataFactoryProvider
    ) {
        $this->legacyExecutor = $requestExecutorFactory->createLegacyRequestExecutor();
        $this->restExecutor = $requestExecutorFactory->createRestRequestExecutor();
        $this->dataFactoryProvider = $dataFactoryProvider;
        $this->restRequestBuilderFactory = $restRequestBuilderFactory;
        $this->legacyRequestBuilderFactory = $legacyRequestBuilderFactory;
    }

    public function profileFeature(): ProfileFeature
    {
        return new ProfileHttpFeature(
            $this->restExecutor,
            $this->dataFactoryProvider
        );
    }
}
