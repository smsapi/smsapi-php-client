<?php
use SMSApi\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_have_same_version_like_changelog()
    {
        $versionFromChangelog = $this->grabVersionFromChangelog();

        $versionFromClient = Client::VERSION;

        $this->assertEquals($versionFromChangelog, $versionFromClient);
    }

    private function grabVersionFromChangelog()
    {
        $changelog = file_get_contents(dirname(dirname(__DIR__)) . '/CHANGELOG.md');

        preg_match('/^## (\d+.\d+.\d+) - \d{4}-\d{2}-\d{2}$/m', $changelog, $matches);

        return $matches[1];
    }
}
