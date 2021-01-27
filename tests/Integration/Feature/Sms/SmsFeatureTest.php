<?php
declare(strict_types=1);

namespace Smsapi\Client\Tests\Integration\Feature\Sms;

use DateTime;
use Smsapi\Client\Feature\Sms\Bag\DeleteScheduledSmssBag;
use Smsapi\Client\Feature\Sms\Bag\ScheduleSmsBag;
use Smsapi\Client\Feature\Sms\Bag\ScheduleSmssBag;
use Smsapi\Client\Feature\Sms\Bag\SendSmsBag;
use Smsapi\Client\Feature\Sms\Bag\SendSmssBag;
use Smsapi\Client\Feature\Sms\Data\Sms;
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
        $sendSmsBag = $this->givenSmsToSend();
        $sendSmsBag->test = true;

        $result = $smsFeature->sendSms($sendSmsBag);

        $this->assertEquals($sendSmsBag->to, $result->number);
    }

    /**
     * @test
     */
    public function it_should_send_sms_with_external_id()
    {
        $smsFeature = self::$smsapiService->smsFeature();
        $sendSmsBag = $this->givenSmsToSend();
        $sendSmsBag->setExternalId('any');
        $sendSmsBag->test = true;

        $result = $smsFeature->sendSms($sendSmsBag);

        $this->assertEquals($sendSmsBag->to, $result->number);
        $this->assertEquals($sendSmsBag->idx[0], $result->idx);
    }

    /**
     * @test
     */
    public function it_should_receive_content_details_for_single_sms()
    {
        $smsFeature = self::$smsapiService->smsFeature();
        $sendSmsBag = $this->givenSmsToSend();
        $sendSmsBag->test = true;

        $result = $smsFeature->sendSms($sendSmsBag);

        $this->assertNotNull($result->content);
        $this->assertEquals($sendSmsBag->message, $result->content->message);
        $this->assertEquals(mb_strlen($sendSmsBag->message), $result->content->length);
        $this->assertEquals(1, $result->content->parts);
    }

    /**
     * @test
     */
    public function it_should_send_flash_sms()
    {
        $smsFeature = self::$smsapiService->smsFeature();
        $sendFlashSmsBag = $this->givenSmsToSend();
        $sendFlashSmsBag->test = true;

        $result = $smsFeature->sendFlashSms($sendFlashSmsBag);

        $this->assertEquals($sendFlashSmsBag->to, $result->number);
    }

    /**
     * @test
     */
    public function it_should_send_smss()
    {
        $smsFeature = self::$smsapiService->smsFeature();
        $sendSmssBag = $this->givenSmssToSend();
        $sendSmssBag->test = true;

        $results = $smsFeature->sendSmss($sendSmssBag);

        $this->assertCount(count($sendSmssBag->to), $results);
    }

    /**
     * @test
     */
    public function it_should_send_flash_smss()
    {
        $smsFeature = self::$smsapiService->smsFeature();
        $sendSmssBag = $this->givenSmssToSend();
        $sendSmssBag->test = true;

        $results = $smsFeature->sendFlashSmss($sendSmssBag);

        $this->assertCount(count($sendSmssBag->to), $results);
    }

    /**
     * @test
     */
    public function it_should_not_receive_content_details_for_smss()
    {
        $smsFeature = self::$smsapiService->smsFeature();
        $sendSmsesBag = $this->givenSmssToSend();
        $sendSmsesBag->test = true;

        /** @var Sms[] $results */
        $results = $smsFeature->sendSmss($sendSmsesBag);

        foreach ($results as $result) {
            $this->assertNull($result->content);
        }
    }

    /**
     * @test
     */
    public function it_should_schedule_sms()
    {
        $smsFeature = self::$smsapiService->smsFeature();
        $scheduleSmsBag = $this->givenSmsToSchedule();
        $scheduleSmsBag->test = true;

        $result = $smsFeature->scheduleSms($scheduleSmsBag);

        $this->assertEquals($scheduleSmsBag->date, $result->dateSent);
        $this->assertEquals($scheduleSmsBag->to, $result->number);
    }

    /**
     * @test
     */
    public function it_should_schedule_smss()
    {
        $smsFeature = self::$smsapiService->smsFeature();
        $scheduleSmssBag = $this->givenSmssToSchedule();
        $scheduleSmssBag->test = true;

        $results = $smsFeature->scheduleSmss($scheduleSmssBag);

        $this->assertCount(count($scheduleSmssBag->to), $results);
    }

    /**
     * @test
     */
    public function it_should_schedule_flash_sms()
    {
        $smsFeature = self::$smsapiService->smsFeature();
        $scheduleFlashSmsBag = $this->givenSmsToSchedule();
        $scheduleFlashSmsBag->test = true;

        $result = $smsFeature->scheduleFlashSms($scheduleFlashSmsBag);

        $this->assertEquals($scheduleFlashSmsBag->date, $result->dateSent);
        $this->assertEquals($scheduleFlashSmsBag->to, $result->number);
    }

    /**
     * @test
     */
    public function it_should_delete_scheduled_smss()
    {
        $smsFeature = self::$smsapiService->smsFeature();
        $scheduleSmssBag = $this->givenSmssToSchedule();

        $results = $smsFeature->scheduleSmss($scheduleSmssBag);
        $smsIds = array_map(function (Sms $sms) {
            return $sms->id;
        }, $results);

        $deleteScheduledSmssBag = new DeleteScheduledSmssBag($smsIds);
        $smsFeature->deleteScheduledSms($deleteScheduledSmssBag);

        $this->assertTrue(true);
    }

    private function givenSmsToSend(): SendSmsBag
    {
        $someReceiver = PhoneNumberFixture::anyValidMobile();
        return SendSmsBag::withMessage($someReceiver, 'some message');
    }

    private function givenSmssToSend(): SendSmssBag
    {
        $receivers = [
            PhoneNumberFixture::anyValidMobile(),
            PhoneNumberFixture::anyValidMobile(),
        ];
        return SendSmssBag::withMessage($receivers, 'some message');
    }

    private function givenSmsToSchedule(): ScheduleSmsBag
    {
        $someDate = new DateTime('+1 day noon');
        $someReceiver = PhoneNumberFixture::anyValidMobile();
        return ScheduleSmsBag::withMessage($someDate, $someReceiver, 'some message');
    }

    private function givenSmssToSchedule(): ScheduleSmssBag
    {
        $someDate = new DateTime('+1 day noon');
        $receivers = [
            PhoneNumberFixture::anyValidMobile(),
            PhoneNumberFixture::anyValidMobile(),
        ];
        return ScheduleSmssBag::withMessage($someDate, $receivers, 'some message');
    }
}
