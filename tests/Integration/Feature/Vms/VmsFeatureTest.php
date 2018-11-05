<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Integration\Feature\Vms;

use Smsapi\Client\Feature\Vms\Bag\SendVmsBag;
use Smsapi\Client\Feature\Vms\VmsFeature;
use Smsapi\Client\Tests\SmsapiClientIntegrationTestCase;

class VmsFeatureTest extends SmsapiClientIntegrationTestCase
{

    /** @var VmsFeature */
    private $feature;

    /**
     * @before
     */
    public function before()
    {
        $this->feature = self::$smsapiService->vmsFeature();
    }

    /**
     * @test
     */
    public function it_should_send_vms()
    {
        $receiver = '48781441345';
        $sendVmsBag = new SendVmsBag($receiver, 'some message');
        $sendVmsBag->test = true;

        $result = $this->feature->sendVms($sendVmsBag);

        $this->assertEquals($receiver, $result->number);
    }
}
