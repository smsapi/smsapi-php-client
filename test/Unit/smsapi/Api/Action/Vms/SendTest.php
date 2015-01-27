<?php

namespace SMSApi\Api\Action\Vms;

use SMSApi\Api\Response\StatusResponse;
use SMSApi\Client;

class SendTest extends \PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        $sendVmsAction = new Get();

        $proxy = $this->getMock('\SMSApi\Proxy\Http\Native', array(), array(''));

        $proxy->expects($this->any())
            ->method('execute')
            ->will($this->returnValue('{}'));

        $sendVmsAction->client(new Client('test'));
        $sendVmsAction->proxy($proxy);

        $result = $sendVmsAction->execute();

        $this->assertInstanceOf('SMSApi\Api\Response\StatusResponse', $result);
    }
}