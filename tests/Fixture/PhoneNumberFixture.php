<?php
declare(strict_types=1);

namespace Smsapi\Client\Tests\Fixture;

class PhoneNumberFixture
{
    public static function anyPhoneNumber(): string
    {
        return '48781441345';
    }

    public static function anotherPhoneNumber(): string
    {
        return '48781441346';
    }
}
