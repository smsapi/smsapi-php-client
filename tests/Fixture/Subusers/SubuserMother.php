<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Fixture\Subusers;

use Smsapi\Client\Feature\Data\Points;
use Smsapi\Client\Feature\Subusers\Data\Subuser;

class SubuserMother
{
    public static function createAnySubuser(): Subuser
    {
        $subuser = new Subuser();
        $subuser->username = SubuserFixture::createAnySubuserName();
        $subuser->points = new Points();
        $subuser->points->fromAccount = 0;
        $subuser->points->perMonth = 0;
        $subuser->active = false;
        $subuser->description = '';

        return $subuser;
    }
}
