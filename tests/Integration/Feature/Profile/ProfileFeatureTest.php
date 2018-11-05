<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Integration\Feature\Profile;

use Smsapi\Client\Feature\Profile\SmsapiPlProfileFeature;
use Smsapi\Client\Feature\Profile\ProfileFeature;
use Smsapi\Client\Tests\Assert\ProfileAssert;
use Smsapi\Client\Tests\Assert\ProfilePriceAssert;
use Smsapi\Client\Tests\SmsapiClientIntegrationTestCase;

class ProfileFeatureTest extends SmsapiClientIntegrationTestCase
{

    /** @var ProfileFeature|SmsapiPlProfileFeature */
    private $feature;

    /** @var ProfileAssert */
    private $profileAssert;

    /** @var ProfilePriceAssert */
    private $profilePriceAssert;

    /**
     * @before
     */
    public function before()
    {
        $this->feature = self::$smsapiService->profileFeature();
        $this->profileAssert = new ProfileAssert();
        $this->profilePriceAssert = new ProfilePriceAssert();
    }

    /**
     * @test
     */
    public function it_should_find_profile()
    {
        $profile = $this->feature->findProfile();

        $this->profileAssert->assert($profile);
    }

    /**
     * @test
     */
    public function it_should_find_profile_prices()
    {
        self::skipIfServiceIsNotPl();

        $prices = $this->feature->findProfilePrices();

        $this->assertNotEmpty($prices);
        array_map([$this->profilePriceAssert, 'assert'], $prices);
    }
}
