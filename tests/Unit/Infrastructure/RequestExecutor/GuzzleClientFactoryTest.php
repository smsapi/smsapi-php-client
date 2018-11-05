<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Unit\Infrastructure\RequestExecutor;

use GuzzleHttp\ClientInterface;
use Smsapi\Client\Tests\Fixture\GuzzleClientFactoryMother;
use Smsapi\Client\Tests\SmsapiClientUnitTestCase;

class GuzzleClientFactoryTest extends SmsapiClientUnitTestCase
{
    /**
     * @test
     */
    public function it_should_create_guzzle_client()
    {
        $guzzleClientFactory = GuzzleClientFactoryMother::any();

        $result = $guzzleClientFactory->createClient();

        $this->assertInstanceOf(ClientInterface::class, $result);
    }
}
