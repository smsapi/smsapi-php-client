<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Fixture\Subusers;

use Smsapi\Client\Feature\Subusers\Bag\CreateSubuserBag;

class CreateSubuserBagMother
{
    public static function createWithSubuserName(string $subuserName): CreateSubuserBag
    {
        return new CreateSubuserBag($subuserName, PasswordFixture::valid());
    }
}
