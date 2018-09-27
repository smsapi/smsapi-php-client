<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Profile;

use Fig\Http\Message\RequestMethodInterface;
use Smsapi\Client\Feature\Data\DataFactoryProvider;
use Smsapi\Client\Feature\Profile\Data\Profile;
use Smsapi\Client\Infrastructure\Request\RestRequestBuilderFactory;
use Smsapi\Client\Infrastructure\RequestExecutor\RestRequestExecutor;
use Smsapi\Client\SmsapiClientException;

/**
 * @internal
 */
trait ProfileDefaultHttpFeatures
{
    /**
     * @var RestRequestExecutor
     */
    private $restRequestExecutor;

    /**
     * @var RestRequestBuilderFactory
     */
    private $restRequestBuilderFactory;

    /**
     * @var DataFactoryProvider
     */
    private $dataFactoryProvider;

    /**
     * @return Profile
     * @throws SmsapiClientException
     */
    public function findProfile(): Profile
    {
        $requestBuilder = $this->restRequestBuilderFactory->create();

        $request = $requestBuilder
            ->withMethod(RequestMethodInterface::METHOD_GET)
            ->withPath('profile')
            ->get();

        $result = $this->restRequestExecutor->execute($request);

        return $this->dataFactoryProvider
            ->provideProfileFactory()
            ->createFromObject($result);
    }
}
