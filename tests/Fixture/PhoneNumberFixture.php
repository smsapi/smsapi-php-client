<?php
declare(strict_types=1);

namespace Smsapi\Client\Tests\Fixture;

class PhoneNumberFixture
{
    public static $valid = '48327201200';

    public static $validMobile = '48781441345';

    private static $i = 1;

    public static function anyValid(): string
    {
        return (string)((int)self::$valid + self::$i++);
    }

    public static function anyValidMobile(): string
    {
        return (string)((int)self::$validMobile + self::$i++);
    }
}
