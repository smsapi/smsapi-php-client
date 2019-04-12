<?php
declare(strict_types=1);

namespace Smsapi\Client\Tests\Integration\Feature\Mms;

use Smsapi\Client\Feature\Mms\Bag\SendMmsBag;
use Smsapi\Client\Tests\Fixture\PhoneNumberFixture;
use Smsapi\Client\Tests\SmsapiClientIntegrationTestCase;

class MmsFeatureTest extends SmsapiClientIntegrationTestCase
{
    /**
     * @test
     */
    public function it_should_send_mms()
    {
        $smsFeature = self::$smsapiService->mmsFeature();
        $someReceiver = PhoneNumberFixture::anyValidMobile();
        $sendSmsBag = new SendMmsBag($someReceiver, 'some message', '<smil></smil>');
        $sendSmsBag->test = true;

        $result = $smsFeature->sendMms($sendSmsBag);

        $this->assertEquals($someReceiver, $result->number);
    }
}
