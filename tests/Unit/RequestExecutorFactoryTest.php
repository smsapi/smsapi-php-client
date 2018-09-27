<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Unit;

use Smsapi\Client\Infrastructure\RequestExecutor\RequestExecutorFactory;
use Smsapi\Client\Tests\Fixture\ClientInterfaceMother;
use Smsapi\Client\Tests\SmsapiClientUnitTestCase;

class RequestExecutorFactoryTest extends SmsapiClientUnitTestCase
{
    /**
     * @test
     *
     * @doesNotPerformAssertions
     */
    public function it_should_create_rest_request_executor()
    {
        $requestExecutorFactory = new RequestExecutorFactory(ClientInterfaceMother::any(), 'foo');

        $requestExecutorFactory->createRestRequestExecutor();
    }

    /**
     * @test
     *
     * @doesNotPerformAssertions
     */
    public function it_should_create_legacy_request_executor()
    {
        $requestExecutorFactory = new RequestExecutorFactory(ClientInterfaceMother::any(), 'foo');

        $requestExecutorFactory->createLegacyRequestExecutor();
    }
}
