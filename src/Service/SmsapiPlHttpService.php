<?php

declare(strict_types=1);

namespace Smsapi\Client\Service;

use Smsapi\Client\Feature\Data\DataFactoryProvider;
use Smsapi\Client\Feature\Mms\MmsFeature;
use Smsapi\Client\Feature\Mms\MmsHttpFeature;
use Smsapi\Client\Feature\Profile\SmsapiPlProfileFeature;
use Smsapi\Client\Feature\Profile\SmsapiPlProfileHttpFeature;
use Smsapi\Client\Feature\Vms\VmsFeature;
use Smsapi\Client\Feature\Vms\VmsHttpFeature;
use Smsapi\Client\Infrastructure\Request\LegacyRequestBuilderFactory;
use Smsapi\Client\Infrastructure\Request\RestRequestBuilderFactory;
use Smsapi\Client\Infrastructure\RequestExecutor\RequestExecutorFactory;

/**
 * @internal
 */
class SmsapiPlHttpService implements SmsapiPlService
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

    public function mmsFeature(): MmsFeature
    {
        return new MmsHttpFeature(
            $this->legacyExecutor,
            $this->legacyRequestBuilderFactory,
            $this->dataFactoryProvider->provideMmsFactory()
        );
    }

    public function vmsFeature(): VmsFeature
    {
        return new VmsHttpFeature(
            $this->legacyExecutor,
            $this->legacyRequestBuilderFactory,
            $this->dataFactoryProvider->provideVmsFactory()
        );
    }

    public function profileFeature(): SmsapiPlProfileFeature
    {
        return new SmsapiPlProfileHttpFeature(
            $this->restExecutor,
            $this->restRequestBuilderFactory,
            $this->dataFactoryProvider
        );
    }
}
