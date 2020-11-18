<?php
declare(strict_types=1);

namespace Smsapi\Client\Tests\Integration\Feature\Ping;

use Smsapi\Client\Tests\SmsapiClientIntegrationTestCase;

class PingFeatureTest extends SmsapiClientIntegrationTestCase
{
    /**
     * @test
     */
    public function it_should_receive_pong()
    {
        $pingFeature = self::$smsapiService->pingFeature();

        $result = $pingFeature->ping();

        $this->assertTrue($result->authorized);
    }
}
