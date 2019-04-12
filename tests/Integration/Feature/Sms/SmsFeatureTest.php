<?php
declare(strict_types=1);

namespace Smsapi\Client\Tests\Integration\Feature\Sms;

use DateTime;
use Smsapi\Client\Feature\Sms\Bag\ScheduleSmsBag;
use Smsapi\Client\Feature\Sms\Bag\ScheduleSmssBag;
use Smsapi\Client\Feature\Sms\Bag\SendSmsBag;
use Smsapi\Client\Feature\Sms\Bag\SendSmssBag;
use Smsapi\Client\Tests\Fixture\PhoneNumberFixture;
use Smsapi\Client\Tests\SmsapiClientIntegrationTestCase;

class SmsFeatureTest extends SmsapiClientIntegrationTestCase
{
    /**
     * @test
     */
    public function it_should_send_sms()
    {
        $smsFeature = self::$smsapiService->smsFeature();
        $someReceiver = PhoneNumberFixture::anyValidMobile();
        $sendSmsBag = SendSmsBag::withMessage($someReceiver, 'some message');
        $sendSmsBag->test = true;

        $result = $smsFeature->sendSms($sendSmsBag);

        $this->assertEquals($someReceiver, $result->number);
    }

    /**
     * @test
     */
    public function it_should_send_sms_with_external_id()
    {
        $smsFeature = self::$smsapiService->smsFeature();
        $someReceiver = PhoneNumberFixture::anyValidMobile();
        $externalId = 'any';
        $sendSmsBag = SendSmsBag::withMessage($someReceiver, 'some message');
        $sendSmsBag->setExternalId($externalId);
        $sendSmsBag->test = true;

        $result = $smsFeature->sendSms($sendSmsBag);

        $this->assertEquals($someReceiver, $result->number);
        $this->assertEquals($externalId, $result->idx);
    }

    /**
     * @test
     */
    public function it_should_receive_details_for_single_sms()
    {
        $message = 'some message';
        $smsFeature = self::$smsapiService->smsFeature();
        $someReceiver = PhoneNumberFixture::anyValidMobile();
        $sendSmsBag = SendSmsBag::withMessage($someReceiver, $message);
        $sendSmsBag->test = true;

        $result = $smsFeature->sendSms($sendSmsBag);

        $this->assertNotNull($result->content);
        $this->assertEquals($message, $result->content->message);
        $this->assertEquals(mb_strlen($message), $result->content->length);
        $this->assertEquals(1, $result->content->parts);
    }

    /**
     * @test
     */
    public function it_should_send_flash_sms()
    {
        $smsFeature = self::$smsapiService->smsFeature();
        $someReceiver = PhoneNumberFixture::anyValidMobile();
        $sendFlashSmsBag = SendSmsBag::withMessage($someReceiver, 'some message');
        $sendFlashSmsBag->test = true;

        $result = $smsFeature->sendFlashSms($sendFlashSmsBag);

        $this->assertEquals($someReceiver, $result->number);
    }

    /**
     * @test
     */
    public function it_should_send_smss()
    {
        $smsFeature = self::$smsapiService->smsFeature();
        $receivers = [
            PhoneNumberFixture::anyValidMobile(),
            PhoneNumberFixture::anyValidMobile(),
        ];
        $sendSmsesBag = SendSmssBag::withMessage($receivers, 'some message');
        $sendSmsesBag->test = true;

        $results = $smsFeature->sendSmss($sendSmsesBag);

        $this->assertCount(2, $results);
    }

    /**
     * @test
     */
    public function it_should_send_flash_smss()
    {
        $smsFeature = self::$smsapiService->smsFeature();
        $receivers = [
            PhoneNumberFixture::anyValidMobile(),
            PhoneNumberFixture::anyValidMobile(),
        ];
        $sendSmsesBag = SendSmssBag::withMessage($receivers, 'some message');
        $sendSmsesBag->test = true;

        $results = $smsFeature->sendFlashSmss($sendSmsesBag);

        $this->assertCount(2, $results);
    }

    /**
     * @test
     */
    public function it_should_not_receive_details_for_smss()
    {
        $smsFeature = self::$smsapiService->smsFeature();
        $receivers = [
            PhoneNumberFixture::anyValidMobile(),
            PhoneNumberFixture::anyValidMobile(),
        ];
        $sendSmsesBag = SendSmssBag::withMessage($receivers, 'some message');
        $sendSmsesBag->test = true;

        $results = $smsFeature->sendSmss($sendSmsesBag);

        foreach ($results as $result) {
            $this->assertNull($result->details);
        }
    }

    /**
     * @test
     */
    public function it_should_schedule_sms()
    {
        $smsFeature = self::$smsapiService->smsFeature();
        $someDate = new DateTime('+1 day noon');
        $someReceiver = PhoneNumberFixture::anyValidMobile();
        $scheduleSmsBag = ScheduleSmsBag::withMessage($someDate, $someReceiver, 'some message');
        $scheduleSmsBag->test = true;

        $result = $smsFeature->scheduleSms($scheduleSmsBag);

        $this->assertEquals($someDate, $result->dateSent);
        $this->assertEquals($someReceiver, $result->number);
    }

    /**
     * @test
     */
    public function it_should_schedule_smss()
    {
        $smsFeature = self::$smsapiService->smsFeature();
        $someDate = new DateTime('+1 day noon');
        $receivers = [
            PhoneNumberFixture::anyValidMobile(),
            PhoneNumberFixture::anyValidMobile(),
        ];
        $scheduleSmsBag = ScheduleSmssBag::withMessage($someDate, $receivers, 'some message');
        $scheduleSmsBag->test = true;

        $results = $smsFeature->scheduleSmss($scheduleSmsBag);

        $this->assertCount(2, $results);
    }

    /**
     * @test
     */
    public function it_should_schedule_flash_sms()
    {
        $smsFeature = self::$smsapiService->smsFeature();
        $someDate = new DateTime('+1 day noon');
        $someReceiver = PhoneNumberFixture::anyValidMobile();
        $scheduleFlashSmsBag = ScheduleSmsBag::withMessage($someDate, $someReceiver, 'some message');
        $scheduleFlashSmsBag->test = true;

        $result = $smsFeature->scheduleFlashSms($scheduleFlashSmsBag);

        $this->assertEquals($someDate, $result->dateSent);
        $this->assertEquals($someReceiver, $result->number);
    }
}
