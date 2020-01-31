<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Integration\Feature\Mfa;

use Smsapi\Client\Feature\Mfa\Bag\CreateMfaBag;
use Smsapi\Client\Feature\Mfa\Bag\VerificationMfaBag;
use Smsapi\Client\Feature\Mfa\Data\Mfa;
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
        $mfaFeature = self::$smsapiService->mfaFeature();
        $createMfaBag = new CreateMfaBag(PhoneNumberFixture::anyValidMobile());
        //when
        $mfa = $mfaFeature->generateMfa($createMfaBag);
        //then
        $this->assertEquals($createMfaBag->phoneNumber, $mfa->phoneNumber);

        return $mfa;
    }

    /**
     * @test
     */
    public function it_should_not_create_mfa_for_an_ivalid_mobile_phone_number()
    {
        //given
        $mfaFeature = self::$smsapiService->mfaFeature();
        $createMfaBag = new CreateMfaBag(PhoneNumberFixture::anyValid());
        //expect
        $this->expectException(SmsapiClientException::class);
        $this->expectExceptionMessage('The value is not valid mobile number.');
        //when
        $mfaFeature->generateMfa($createMfaBag);
    }

    /**
     * @test
     * @depends it_should_create_mfa
     * @param Mfa $mfa
     */
    public function it_should_verify_correct_code(Mfa $mfa)
    {
        //given
        $mfaFeature = self::$smsapiService->mfaFeature();
        $verificationMfaBag = new VerificationMfaBag($mfa->code, $mfa->phoneNumber);
        //when
        $mfaFeature->verifyMfa($verificationMfaBag);
        //then
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function it_should_not_verify_incorrect_code()
    {
        //given
        $mfaFeature = self::$smsapiService->mfaFeature();
        $verificationMfaBag = new VerificationMfaBag('123456', PhoneNumberFixture::anyValidMobile());
        //expect
        $this->expectException(SmsapiClientException::class);
        $this->expectExceptionMessage('Not found');
        //when
        $mfaFeature->verifyMfa($verificationMfaBag);
    }

    /**
     * @test
     */
    public function it_should_not_verify_empty_code()
    {
        //given
        $mfaFeature = self::$smsapiService->mfaFeature();
        $verificationMfaBag = new VerificationMfaBag('', PhoneNumberFixture::anyValidMobile());
        //expect
        $this->expectException(SmsapiClientException::class);
        $this->expectExceptionMessage('MFA code cannot be empty');
        //when
        $mfaFeature->verifyMfa($verificationMfaBag);
    }

    /**
     * @test
     */
    public function it_should_not_verify_invalid_code()
    {
        //given
        $mfaFeature = self::$smsapiService->mfaFeature();
        $verificationMfaBag = new VerificationMfaBag('123 456', PhoneNumberFixture::anyValidMobile());
        //expect
        $this->expectException(SmsapiClientException::class);
        $this->expectExceptionMessage('MFA code has invalid format');
        //when
        $mfaFeature->verifyMfa($verificationMfaBag);
    }
}
