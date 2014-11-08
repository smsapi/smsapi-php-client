<?php

namespace SMSApi\Api\Action\Phonebook;

use SMSApi\Client;

class ContactGetTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ContactGet
     */
    private $getContactAction;

    protected function setUp()
    {
        $addContactAction = new ContactGet();

        $proxy = $this->getMock('\SMSApi\Proxy\Http\Native', array(), array(''));

        $addContactAction->client(new Client('test'));
        $addContactAction->proxy($proxy);

        $this->getContactAction = $addContactAction;
    }

    public function testUriWithGroups()
    {
        $this->getContactAction;

        $uri = $this->getContactAction
            ->uri();

        $this->assertEquals('username=test&password=&with_groups=1', $uri->getQuery());
    }

}
 