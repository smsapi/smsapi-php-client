<?php

namespace SMSApi\Api\Action\Phonebook;

use SMSApi\Client;

class ContactAddTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var ContactAdd
     */
    private $addContactAction;

    protected function setUp()
    {
        $addContactAction = new ContactAdd();

        $proxy = $this->getMock('\SMSApi\Proxy\Http\Native', array(), array(''));

        $addContactAction->client(new Client('test'));
        $addContactAction->proxy($proxy);

        $this->addContactAction = $addContactAction;
    }

    public function testUriWithGroups()
    {
        $this->addContactAction
            ->setGroups(array(
               'group1', 'group2'
            ));

        $uri = $this->addContactAction
            ->uri();

        $this->assertEquals('username=test&password=&groups=group1,group2', $uri->getQuery());
    }

}
 