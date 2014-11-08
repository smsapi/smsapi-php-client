<?php

namespace SMSApi\Api\Action\Phonebook;

use SMSApi\Client;

class ContactEditTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var ContactEdit
     */
    private $editContactAction;

    protected function setUp()
    {
        $editContactAction = new ContactEdit();

        $proxy = $this->getMock('\SMSApi\Proxy\Http\Native', array(), array(''));

        $editContactAction->client(new Client('test'));
        $editContactAction->proxy($proxy);

        $this->editContactAction = $editContactAction;
    }

    public function testUriWithAddToGroup()
    {
        $this->editContactAction->addToGroup('test_group');

        $result = $this->editContactAction->uri();

        $this->assertEquals('username=test&password=&add_to_group=test_group', $result->getQuery());
    }


    public function testUriWithRemoveFromGroup()
    {
        $this->editContactAction->removeFromGroup('test_group');

        $result = $this->editContactAction->uri();

        $this->assertEquals('username=test&password=&remove_from_groups=test_group', $result->getQuery());
    }

}
 