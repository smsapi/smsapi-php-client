<?php

declare(strict_types=1);

namespace Smsapi\Client\Service;

use Psr\Http\Client\ClientInterface;
use Smsapi\Client\Feature\Data\DataFactoryProvider;
use Smsapi\Client\Feature\Mms\MmsFeature;
use Smsapi\Client\Feature\Mms\MmsHttpFeature;
use Smsapi\Client\Feature\Profile\SmsapiPlProfileFeature;
use Smsapi\Client\Feature\Profile\SmsapiPlProfileHttpFeature;
use Smsapi\Client\Feature\Vms\VmsFeature;
use Smsapi\Client\Feature\Vms\VmsHttpFeature;
use Smsapi\Client\Infrastructure\RequestExecutor\RequestExecutorFactory;

/**
 * @internal
 */
class SmsapiPlHttpService implements SmsapiPlService
{
    use HttpDefaultFeatures;

    private $externalHttpClient;
    private $requestExecutorFactory;
    private $dataFactoryProvider;

    public function __construct(
        ClientInterface $externalHttpClient,
        RequestExecutorFactory $requestExecutorFactory,
        DataFactoryProvider $dataFactoryProvider
    ) {
        $this->externalHttpClient = $externalHttpClient;
        $this->requestExecutorFactory = $requestExecutorFactory;
        $this->dataFactoryProvider = $dataFactoryProvider;
    }

    public function mmsFeature(): MmsFeature
    {
        return new MmsHttpFeature(
            $this->requestExecutorFactory->createLegacyRequestExecutor($this->externalHttpClient),
            $this->dataFactoryProvider->provideMmsFactory()
        );
    }

    public function vmsFeature(): VmsFeature
    {
        return new VmsHttpFeature(
            $this->requestExecutorFactory->createLegacyRequestExecutor($this->externalHttpClient),
            $this->dataFactoryProvider->provideVmsFactory()
        );
    }

    public function profileFeature(): SmsapiPlProfileFeature
    {
        return new SmsapiPlProfileHttpFeature(
            $this->requestExecutorFactory->createRestRequestExecutor($this->externalHttpClient),
            $this->dataFactoryProvider
        );
    }
}
