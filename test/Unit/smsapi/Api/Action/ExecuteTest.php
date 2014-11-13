<?php

namespace SMSApi\Api\Action;

use SMSApi\Api\Action\Vms\Delete as VmsDelete;
use SMSApi\Api\Action\Vms\Get as VmsGet;
use SMSApi\Api\Action\Vms\Send as VmsSend;

use SMSApi\Api\Action\Sms\Delete as SmsDelete;
use SMSApi\Api\Action\Sms\Get as SmsGet;
use SMSApi\Api\Action\Sms\Send as SmsSend;

use SMSApi\Api\Action\Mms\Delete as MmsDelete;
use SMSApi\Api\Action\Mms\Get as MmsGet;
use SMSApi\Api\Action\Mms\Send as MmsSend;

use SMSApi\Client;

class ExecuteTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider statusResponseDataProvider
     */
    public function testExecuteReturnsStatusResponse(AbstractAction $action)
    {
        $proxyStub = $this->prepareProxyStub();
        $client = new Client('test');

        $action->client($client);
        $action->proxy($proxyStub);

        $result = $action->execute();

        $this->assertInstanceOf('SMSApi\Api\Response\StatusResponse', $result);
    }

    public function statusResponseDataProvider()
    {
        return array(
            array(new VmsSend()),
            array(new VmsGet()),

            array(new SmsSend()),
            array(new SmsGet()),

            array(new MmsSend()),
            array(new MmsGet())
        );
    }

    /**
     * @dataProvider countableResponseDataProvider
     */
    public function testExecuteReturnsCountableResponse(AbstractAction $action)
    {
        $proxyStub = $this->prepareProxyStub();
        $client = new Client('test');

        $action->client($client);
        $action->proxy($proxyStub);

        $result = $action->execute();

        $this->assertInstanceOf('SMSApi\Api\Response\CountableResponse', $result);
    }

    public function countableResponseDataProvider()
    {
        return array(
            array(new VmsDelete()),

            array(new SmsDelete()),

            array(new MmsDelete())
        );
    }

    private function prepareProxyStub()
    {
        $proxyStub = $this->getMock('\SMSApi\Proxy\Http\Native', array(), ['']);

        $proxyStub->expects($this->once())
            ->method('execute')
            ->will($this->returnValue('{}'));

        return $proxyStub;
    }
}
