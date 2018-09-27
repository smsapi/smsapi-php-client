<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Profile;

use Fig\Http\Message\RequestMethodInterface;
use Smsapi\Client\Feature\Data\DataFactoryProvider;
use Smsapi\Client\Infrastructure\Request\RestRequestBuilderFactory;
use Smsapi\Client\Infrastructure\RequestExecutor\RestRequestExecutor;

/**
 * @api
 */
class SmsapiPlProfileHttpFeature implements SmsapiPlProfileFeature
{
    use ProfileDefaultHttpFeatures;

    public function __construct(
        RestRequestExecutor $restRequestExecutor,
        RestRequestBuilderFactory $restRequestBuilderFactory,
        DataFactoryProvider $dataFactoryProvider
    ) {
        $this->restRequestExecutor = $restRequestExecutor;
        $this->restRequestBuilderFactory = $restRequestBuilderFactory;
        $this->dataFactoryProvider = $dataFactoryProvider;
    }

    public function findProfilePrices(): array
    {
        $requestBuilder = $this->restRequestBuilderFactory->create();

        $request = $requestBuilder
            ->withMethod(RequestMethodInterface::METHOD_GET)
            ->withPath('profile/prices')
            ->get();

        $result = $this->restRequestExecutor->execute($request);

        return array_map(
            [$this->dataFactoryProvider->provideProfilePriceFactory(), 'createFromObject'],
            $result->collection
        );
    }
}
