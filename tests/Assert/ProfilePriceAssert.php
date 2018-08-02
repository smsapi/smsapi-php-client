<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Assert;

use DateTimeInterface;
use PHPUnit\Framework\Assert;
use Smsapi\Client\Feature\Profile\Data\ProfilePrice;
use Smsapi\Client\Feature\Profile\Data\ProfilePriceCountry;
use Smsapi\Client\Feature\Profile\Data\ProfilePriceNetwork;

class ProfilePriceAssert extends Assert
{
    private $moneyAssert;

    public function __construct()
    {
        $this->moneyAssert = new MoneyAssert();
    }

    public function assert(ProfilePrice $profilePrice)
    {
        $this->assertNotEmpty($profilePrice->type);
        $this->moneyAssert->assertMoney($profilePrice->price);
        $this->assertCountry($profilePrice->country);
        $this->assertNetwork($profilePrice->network);
        if ($profilePrice->changedAt) {
            $this->assertInstanceOf(DateTimeInterface::class, $profilePrice->changedAt);
        }
    }

    private function assertCountry(ProfilePriceCountry $country)
    {
        $this->assertNotEmpty($country->name);
        $this->assertGreaterThanOrEqual(0, $country->mcc);
    }

    private function assertNetwork(ProfilePriceNetwork $network)
    {
        $this->assertNotEmpty($network->name);
        $this->assertGreaterThanOrEqual(0, $network->mnc);
    }
}
