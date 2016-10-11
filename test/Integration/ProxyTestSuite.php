<?php
use SMSApi\Client;
use SMSApi\Proxy\Proxy;

abstract class ProxyTestSuite extends PHPUnit_Framework_TestSuite
{
    public function injectProxyAndClient(Proxy $proxy = null, Proxy $contactsProxy = null, Client $client = null)
    {
        foreach ($this->tests() as $testSuite) {
            foreach ($testSuite->tests() as $testCase) {
                if ($testCase instanceof SmsapiTestCase) {
                    if ($proxy) {
                        $testCase->setProxy($proxy);
                    }
                    if ($contactsProxy) {
                        $testCase->setContactsProxy($contactsProxy);
                    }
                    if ($client) {
                        $testCase->setClient($client);
                    }
                }
            }
        }
    }

    public function addTestsToSuite()
    {
        $config = self::getConfiguration();

        if (empty($config['contacts_login'])) {
            $this->addTestSuite('PhonebookTest');
        } else {
            $this->addTestSuite('ContactsTest');
        }

        $this->addTestSuite('MmsTest');
        $this->addTestSuite('SenderTest');
        $this->addTestSuite('SmsTest');
        $this->addTestSuite('UserTest');
        $this->addTestSuite('VmsTest');
    }

    protected static function getHost()
    {
        $config = self::getConfiguration();

        return $config['host'];
    }

    protected static function getContactsHost()
    {
        $configuration = self::getConfiguration();

        return $configuration['contacts_host'];
    }

    protected static function getConfiguration()
    {
        return include __DIR__ . '/config.php';
    }
}
