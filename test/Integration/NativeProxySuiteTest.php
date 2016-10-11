<?php
use SMSApi\Proxy\Http\Native;

class NativeProxySuiteTest extends \ProxyTestSuite
{
    protected function setUp()
    {
        echo "\n\n--------------\nExecuting Native Proxy\n\n";
    }

    public static function suite()
    {
        $suite = new NativeProxySuiteTest();

        $suite->addTestsToSuite();

        $nativeProxy = new Native(self::getHost());

        $suite->injectProxyAndClient($nativeProxy, new Native(self::getContactsHost()));

        return $suite;
    }
}
