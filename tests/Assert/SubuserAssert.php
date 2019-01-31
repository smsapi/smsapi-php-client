<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Assert;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\AssertionFailedError;
use Smsapi\Client\Feature\Data\Points;
use Smsapi\Client\Feature\Subusers\Bag\UpdateSubuserBag;
use Smsapi\Client\Feature\Subusers\Data\Subuser;

class SubuserAssert extends Assert
{
    public function assertContainsSubuser(Subuser $expected, array $actualSubusers)
    {
        $subuserFound = false;

        foreach ($actualSubusers as $subuser) {
            try {
                $this->assertSubuser($expected, $subuser);
                $subuserFound = true;
            } catch (AssertionFailedError $exception) {
                // ignore
            }
        }

        $this->assertTrue($subuserFound);
    }

    public function assertSubuser(Subuser $expected, Subuser $actualSubuser)
    {
        $this->assertEquals($expected->username, $actualSubuser->username);
        $this->assertEquals($actualSubuser->active, $actualSubuser->active);
        $this->assertEquals($actualSubuser->description, $actualSubuser->description);

        $this->assertSubuserPoints($expected->points, $actualSubuser->points);
    }

    public function assertSubuserUpdated(UpdateSubuserBag $expected, Subuser $actualSubuser)
    {
        $this->assertEquals($expected->description, $actualSubuser->description);
        $this->assertEquals($expected->active, $actualSubuser->active);
        $this->assertEquals($expected->points['from_account'], $actualSubuser->points->fromAccount);
        $this->assertEquals($expected->points['per_month'], $actualSubuser->points->perMonth);
    }

    private function assertSubuserPoints(Points $expected, Points $actualPoints)
    {
        $this->assertEquals($expected->fromAccount, $actualPoints->fromAccount);
        $this->assertEquals($expected->perMonth, $actualPoints->perMonth);
    }
}
