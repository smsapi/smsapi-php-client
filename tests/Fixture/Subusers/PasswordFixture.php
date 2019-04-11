<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Fixture\Subusers;

class PasswordFixture
{
    public static function valid(): string
    {
        return uniqid('P4ssw0rd');
    }
}
