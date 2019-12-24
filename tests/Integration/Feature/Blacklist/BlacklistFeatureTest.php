<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Integration\Feature\Blacklist;

use DateTimeImmutable;
use Smsapi\Client\Feature\Blacklist\Bag\CreateBlacklistedPhoneNumberBag;
use Smsapi\Client\Feature\Blacklist\Bag\DeleteBlacklistedPhoneNumberBag;
use Smsapi\Client\Feature\Blacklist\Bag\FindBlacklistedPhoneNumbersBag;
use Smsapi\Client\Feature\Blacklist\BlacklistFeature;
use Smsapi\Client\Feature\Blacklist\Data\BlacklistedPhoneNumber;
use Smsapi\Client\Tests\Fixture\PhoneNumberFixture;
use Smsapi\Client\Tests\SmsapiClientIntegrationTestCase;

class BlacklistFeatureTest extends SmsapiClientIntegrationTestCase
{
    /** @var string */
    private static $phoneNumber;

    /** @var BlacklistFeature */
    private $feature;

    /**
     * @before
     */
    public function before()
    {
        self::$phoneNumber = PhoneNumberFixture::$valid;
        $this->feature = self::$smsapiService->blacklistFeature();
    }

    /**
     * @afterClass
     */
    public function after()
    {
        $blacklistPhoneNumbersFindBag = new FindBlacklistedPhoneNumbersBag();
        $blacklistPhoneNumbersFindBag->q = self::$phoneNumber;

        $foundBlacklistedPhoneNumbers = $this->feature->findBlacklistedPhoneNumbers($blacklistPhoneNumbersFindBag);
        if (empty($foundBlacklistedPhoneNumbers)) {
            return;
        }

        $blacklistPhoneNumberDeleteBag = new DeleteBlacklistedPhoneNumberBag($foundBlacklistedPhoneNumbers[0]->id);
        $this->feature->deleteBlacklistedPhoneNumber($blacklistPhoneNumberDeleteBag);
    }

    /**
     * @test
     */
    public function it_should_create_blacklisted_phone_number()
    {
        $phoneNumberToBlacklist = new CreateBlacklistedPhoneNumberBag(self::$phoneNumber);

        $blacklistedPhoneNumber = $this->feature->createBlacklistedPhoneNumber($phoneNumberToBlacklist);

        $this->assertEquals($phoneNumberToBlacklist->phoneNumber, $blacklistedPhoneNumber->phoneNumber);
        $this->assertNull($blacklistedPhoneNumber->expireAt);

        return $blacklistedPhoneNumber;
    }

    /**
     * @test
     * @depends it_should_create_blacklisted_phone_number
     */
    public function it_should_find_blacklisted_phone_number(BlacklistedPhoneNumber $blacklistedPhoneNumber)
    {
        $blacklistPhoneNumbersFindBag = new FindBlacklistedPhoneNumbersBag();
        $blacklistPhoneNumbersFindBag->q = $blacklistedPhoneNumber->phoneNumber;

        $foundBlacklistedPhoneNumbers = $this->feature->findBlacklistedPhoneNumbers($blacklistPhoneNumbersFindBag);

        $this->assertTrue(
            $this->containsBlacklistedPhoneNumber($blacklistedPhoneNumber, ...$foundBlacklistedPhoneNumbers),
            'Phone number not blacklisted'
        );
    }

    /**
     * @test
     * @depends it_should_create_blacklisted_phone_number
     */
    public function it_should_delete_blacklisted_phone_number(BlacklistedPhoneNumber $blacklistedPhoneNumber)
    {
        $blacklistPhoneNumberDeleteBag = new DeleteBlacklistedPhoneNumberBag($blacklistedPhoneNumber->id);
        $this->feature->deleteBlacklistedPhoneNumber($blacklistPhoneNumberDeleteBag);

        $this->assertPhoneNumberDeletedFromBlacklist($blacklistedPhoneNumber);
    }

    /**
     * @test
     * @depends it_should_delete_blacklisted_phone_number
     */
    public function it_should_create_blacklisted_phone_number_with_expire_date()
    {
        $phoneNumberToBlacklist = new CreateBlacklistedPhoneNumberBag(self::$phoneNumber);
        $phoneNumberToBlacklist->expireAt = new DateTimeImmutable('tomorrow');

        $blacklistedPhoneNumber = $this->feature->createBlacklistedPhoneNumber($phoneNumberToBlacklist);

        $this->assertEquals($phoneNumberToBlacklist->phoneNumber, $blacklistedPhoneNumber->phoneNumber);
        $this->assertEquals($phoneNumberToBlacklist->expireAt, $blacklistedPhoneNumber->expireAt);

        return $blacklistedPhoneNumber;
    }

    /**
     * @test
     * @depends it_should_create_blacklisted_phone_number_with_expire_date
     */
    public function it_should_delete_all_blacklisted_phone_numbers(BlacklistedPhoneNumber $blacklistedPhoneNumber)
    {
        $this->feature->deleteBlacklistedPhoneNumbers();

        $this->assertPhoneNumberDeletedFromBlacklist($blacklistedPhoneNumber);
    }

    private function assertPhoneNumberDeletedFromBlacklist(BlacklistedPhoneNumber $blacklistedPhoneNumber)
    {
        $blacklistPhoneNumbersFindBag = new FindBlacklistedPhoneNumbersBag();
        $blacklistPhoneNumbersFindBag->q = $blacklistedPhoneNumber->phoneNumber;

        $foundBlacklistedPhoneNumbers = $this->feature->findBlacklistedPhoneNumbers($blacklistPhoneNumbersFindBag);

        $this->assertFalse(
            $this->containsBlacklistedPhoneNumber($blacklistedPhoneNumber, ...$foundBlacklistedPhoneNumbers),
            'Phone number not deleted from blacklist'
        );
    }

    private function containsBlacklistedPhoneNumber(
        BlacklistedPhoneNumber $expectedBlacklistedPhoneNumber,
        BlacklistedPhoneNumber ...$blacklistedPhoneNumbers
    ): bool {
        $expectedBlacklistedPhoneNumberFound = false;
        foreach ($blacklistedPhoneNumbers as $foundBlacklistedPhoneNumber) {
            if ($foundBlacklistedPhoneNumber->phoneNumber == $expectedBlacklistedPhoneNumber->phoneNumber) {
                $expectedBlacklistedPhoneNumberFound = true;
            }
        }
        return $expectedBlacklistedPhoneNumberFound;
    }
}
