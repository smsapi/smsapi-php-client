<?php

declare(strict_types=1);

namespace Smsapi\Client\Service;

use Psr\Http\Client\ClientInterface;
use Smsapi\Client\Feature\Data\DataFactoryProvider;
use Smsapi\Client\Feature\Profile\ProfileFeature;
use Smsapi\Client\Feature\Profile\ProfileHttpFeature;
use Smsapi\Client\Infrastructure\RequestExecutor\RequestExecutorFactory;

/**
 * @internal
 */
class SmsapiComHttpService implements SmsapiComService
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

    public function profileFeature(): ProfileFeature
    {
        return new ProfileHttpFeature(
            $this->requestExecutorFactory->createRestRequestExecutor($this->externalHttpClient),
            $this->dataFactoryProvider
        );
    }
}
