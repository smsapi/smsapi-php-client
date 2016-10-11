<?php
use SMSApi\Proxy\Http\Curl;

class CurlProxySuiteTest extends \ProxyTestSuite
{
    protected function setUp()
    {
        if (!extension_loaded('curl')) {
            $this->markTestSuiteSkipped('Curl extension is not available.');
        }

        echo "\n\n--------------\nExecuting Curl Proxy\n\n";
    }

    public static function suite()
    {
        $suite = new CurlProxySuiteTest();

        $suite->addTestsToSuite();

        $curlProxy = new Curl(self::getHost());

        $suite->injectProxyAndClient($curlProxy, new Curl(self::getContactsHost()));

        return $suite;
    }
}
