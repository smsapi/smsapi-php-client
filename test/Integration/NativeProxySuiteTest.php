<?php

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

        $nativeProxy = new \SMSApi\Proxy\Http\Native(self::getHost());

        $suite->injectProxy($nativeProxy);

        return $suite;
    }
}
