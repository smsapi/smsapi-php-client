<?php

namespace SMSApi\Api\Action\Vms;

use SMSApi\Client;

class DeleteTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Delete
     */
    private $deleteVmsAction;

    protected function setUp()
    {
        $deleteVmsAction = new Delete();

        $proxy = $this->getMock('\SMSApi\Proxy\Http\Native', array(), array(''));

        $proxy->expects($this->any())
            ->method('execute')
            ->will($this->returnValue('{}'));

        $deleteVmsAction->client(new Client('test'));
        $deleteVmsAction->proxy($proxy);

        $this->deleteVmsAction = $deleteVmsAction;
    }

    public function testUriReturnsUri()
    {
        $result = $this->deleteVmsAction->uri();

        $this->assertInstanceOf('\SMSApi\Proxy\Uri', $result);
    }

    public function testUriWithNoFilter()
    {
        $result = $this->deleteVmsAction->uri();

        $this->assertEquals('username=test&password=&sch_del=', $result->getQuery());
    }

    public function testUriWithOneIdFilter()
    {
        $this->deleteVmsAction->filterByIds(array('deleteId'));

        $result = $this->deleteVmsAction->uri();

        $this->assertEquals('username=test&password=&sch_del=deleteId', $result->getQuery());
    }

    public function testUriWithManyIdFilter()
    {
        $this->deleteVmsAction->filterByIds(array('del1', 'del2', 'del3'));

        $result = $this->deleteVmsAction->uri();

        $this->assertEquals('username=test&password=&sch_del=del1,del2,del3', $result->getQuery());
    }

}
