<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Integration\Feature\Mfa;

use Smsapi\Client\Feature\Sms\Mfa\Bag\CreateMfaBag;
use Smsapi\Client\SmsapiClientException;
use Smsapi\Client\Tests\Fixture\PhoneNumberFixture;
use Smsapi\Client\Tests\SmsapiClientIntegrationTestCase;

class MfaFeatureTest extends SmsapiClientIntegrationTestCase
{
    /**
     * @test
     */
    public function it_should_create_mfa()
    {
        //given
        $mfaFeature = self::$smsapiService->smsFeature()->mfaFeature();
        $createMfaBag = new CreateMfaBag($someReceiver = PhoneNumberFixture::anyValidMobile());
        //when
        $result = $mfaFeature->createMfa($createMfaBag);
        //then
        $this->assertEquals($createMfaBag->phone_number, $result->phoneNumber);
    }

    /**
     * @test
     */
    public function it_should_not_create_mfa_for_an_ivalid_mobile_phone_number()
    {
        //given
        $mfaFeature = self::$smsapiService->smsFeature()->mfaFeature();
        $createMfaBag = new CreateMfaBag($someReceiver = PhoneNumberFixture::anyValid());
        //expect
        $this->expectException(SmsapiClientException::class);
        //when
        $mfaFeature->createMfa($createMfaBag);
    }
}
