<?php

abstract class ProxyTestSuite extends PHPUnit_Framework_TestSuite
{
    public function injectProxy(\SMSApi\Proxy\Proxy $proxy = null)
    {
        foreach ($this->tests() as $testSuite) {
            foreach ($testSuite->tests() as $testCase) {
                if ($testCase instanceof SmsapiTestCase) {
                    $testCase->setProxy($proxy);
                }
            }
        }
    }

    public function addTestsToSuite()
    {
        $this->addTestSuite('MmsTest');
        $this->addTestSuite('PhonebookTest');
        $this->addTestSuite('SenderTest');
        $this->addTestSuite('SmsTest');
        $this->addTestSuite('UserTest');
        $this->addTestSuite('VmsTest');
    }

    protected static function getHost()
    {
        $config = include __DIR__ . '/config.php';

        return $config['host'];
    }
}
