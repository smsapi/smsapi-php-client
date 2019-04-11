<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Fixture\Subusers;

use Smsapi\Client\Feature\Subusers\Bag\UpdateSubuserBag;

class UpdateSubuserBagMother
{
    public static function createWithId(string $subuserId): UpdateSubuserBag
    {
        $updateSubuserBag = new UpdateSubuserBag($subuserId);
        $updateSubuserBag->active = true;
        $updateSubuserBag->description = uniqid('description');
        $updateSubuserBag->setPoints(10.0, 20.0);
        $updateSubuserBag->setPassword(PasswordFixture::valid());
        $updateSubuserBag->setApiPassword(PasswordFixture::valid());

        return $updateSubuserBag;
    }
}
