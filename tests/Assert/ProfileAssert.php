<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Assert;

use PHPUnit\Framework\Assert;
use Smsapi\Client\Feature\Profile\Data\Profile;

class ProfileAssert extends Assert
{

    public function assert(Profile $profile)
    {
        $this->assertNotEmpty($profile->name);
        $this->assertNotEmpty($profile->username);
        $this->assertNotEmpty($profile->email);
        $this->assertStringMatchesFormat('%S', $profile->phoneNumber);
        $this->assertNotEmpty($profile->paymentType);
        $this->assertNotEmpty($profile->userType);
        $this->assertProfilePoints($profile);
    }

    private function assertProfilePoints(Profile $profile)
    {
        if ($profile->points !== null) {
            $this->assertGreaterThanOrEqual(0, $profile->points);
        }
    }
}
