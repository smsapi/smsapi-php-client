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

        $nativeProxy = new \SMSApi\Proxy\Http\Native('https://ssl.smsapi.pl');

        $suite->injectProxy($nativeProxy);

        return $suite;
    }
}