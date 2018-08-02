<?php
declare(strict_types=1);

namespace Smsapi\Client\Tests;

class Fixture
{
    public static function getJson(string $name): string
    {
        $fixturePath = realpath(sprintf('%s/%s.json', FIXTURES_DIR, $name));

        return file_get_contents($fixturePath);
    }
}
