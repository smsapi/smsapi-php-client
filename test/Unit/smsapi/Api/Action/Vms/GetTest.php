<?php

namespace SMSApi\Api\Action\Vms;

use SMSApi\Api\Response\StatusResponse;
use SMSApi\Client;

class GetTest extends \PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        $getVmsAction = new Get();

        $proxy = $this->getMock('\SMSApi\Proxy\Http\Native', array(), ['']);

        $proxy->expects($this->any())
            ->method('execute')
            ->will($this->returnValue('{}'));

        $getVmsAction->client(new Client('test'));
        $getVmsAction->proxy($proxy);

        $result = $getVmsAction->execute();

        $this->assertInstanceOf(StatusResponse::class, $result);
    }
}