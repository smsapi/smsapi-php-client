<?php

namespace SMSApi\Api\Action\Vms;

use SMSApi\Client;

class GetTest extends \PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        $getVmsAction = new Get();

        $proxy = $this->getMock('\SMSApi\Proxy\Http\Native', array(), array(''));

        $proxy->expects($this->any())
            ->method('execute')
            ->will($this->returnValue('{}'));

        $getVmsAction->client(new Client('test'));
        $getVmsAction->proxy($proxy);

        $result = $getVmsAction->execute();

        $this->assertInstanceOf('SMSApi\Api\Response\StatusResponse', $result);
    }
}