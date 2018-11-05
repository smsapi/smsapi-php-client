<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Unit\Infrastructure\RequestExecutor;

use Smsapi\Client\Infrastructure\RequestExecutor\LegacyRequestExecutor;
use Smsapi\Client\Infrastructure\RequestExecutor\RequestExecutorFactory;
use Smsapi\Client\Infrastructure\RequestExecutor\RestRequestExecutor;
use Smsapi\Client\Tests\Fixture\GuzzleClientFactoryMother;
use Smsapi\Client\Tests\SmsapiClientUnitTestCase;

class RequestExecutorFactoryTest extends SmsapiClientUnitTestCase
{
    /**
     * @test
     */
    public function it_should_create_rest_request_executor()
    {
        $requestExecutorFactory = new RequestExecutorFactory(GuzzleClientFactoryMother::any());

        $result = $requestExecutorFactory->createRestRequestExecutor();

        $this->assertInstanceOf(RestRequestExecutor::class, $result);
    }

    /**
     * @test
     */
    public function it_should_create_legacy_request_executor()
    {
        $requestExecutorFactory = new RequestExecutorFactory(GuzzleClientFactoryMother::any());

        $result = $requestExecutorFactory->createLegacyRequestExecutor();

        $this->assertInstanceOf(LegacyRequestExecutor::class, $result);
    }
}
