<?php
declare(strict_types=1);

namespace Smsapi\Client\Tests\Fixture;

class PhoneNumberFixture
{
    /** @var int */
    private static $i = 0;

    public static function valid(): string
    {
        return (string)(48327201200 + self::$i++);
    }

    public static function validMobile(): string
    {
        return (string)(48781441345 + self::$i++);
    }
}
