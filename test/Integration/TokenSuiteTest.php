<?php
namespace Integration;

use SMSApi\Client;
use SMSApi\Proxy\Http\Native;

class TokenSuiteTest extends \ProxyTestSuite
{
    protected function setUp()
    {
        echo "\n\n--------------\nExecuting Token Auth\n\n";
    }

    public static function suite()
    {
        $suite = new static;

        $suite->addTestsToSuite();

        $nativeProxy = new Native(self::getHost());
        $config = self::getConfiguration();

        $client = new Client($config['api_login']);
        $client->setToken($config['api_token']);

        $suite->injectProxyAndClient($nativeProxy, new Native(self::getContactsHost()), $client);

        return $suite;
    }
}
