<?php
declare(strict_types=1);

namespace Smsapi\Client\Tests\Unit;

use Smsapi\Client\SmsapiClient;
use Smsapi\Client\Tests\SmsapiClientUnitTestCase;

class SmsapiHttpClientTest extends SmsapiClientUnitTestCase
{
    /**
     * @test
     */
    public function it_should_have_same_version_like_changelog()
    {
        $versionFromChangelog = $this->grabVersionFromChangelog();

        $versionFromClient = SmsapiClient::VERSION;

        $this->assertEquals($versionFromChangelog, $versionFromClient);
    }

    private function grabVersionFromChangelog()
    {
        $changelog = file_get_contents(dirname(dirname(__DIR__)) . '/CHANGELOG.md');

        preg_match('/^## \[(?<version>Unreleased|\d+.\d+.\d+)]/m', $changelog, $matches);

        $this->assertArrayHasKey('version', $matches);

        return $matches['version'];
    }
}
