<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Integration\Feature\Hlr;

use Smsapi\Client\Feature\Hlr\Bag\SendHlrBag;
use Smsapi\Client\Feature\Hlr\HlrFeature;
use Smsapi\Client\Tests\SmsapiClientIntegrationTestCase;

class HlrFeatureTest extends SmsapiClientIntegrationTestCase
{

    /** @var HlrFeature */
    private $feature;

    /**
     * @before
     */
    public function before()
    {
        $this->feature = self::$smsapiService->hlrFeature();
    }

    /**
     * @test
     */
    public function it_should_send_hlr()
    {
        $numberToCheck = '48781441345';
        $sendHlrBag = new SendHlrBag($numberToCheck);

        $hlr = $this->feature->sendHlr($sendHlrBag);

        $this->assertEquals($numberToCheck, $hlr->number);
    }
}
