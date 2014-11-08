<?php

namespace SMSApi\Api\Response;


class ContactResponseTest extends \PHPUnit_Framework_TestCase
{

    public function testGetGroupsShouldBeEmpty()
    {
        $data = array();

        $contactResponse = new ContactResponse($data);

        $groups = $contactResponse->getGroups();

        $this->assertInternalType('array', $groups);
        $this->assertEmpty($groups);
    }

    public function testResponseReturnContactGroups()
    {

        $data['groups'] = array(
            'group1',
            'group2',
        );

        $contactResponse = new ContactResponse((object)$data);

        $this->assertEquals($data['groups'], $contactResponse->getGroups());

    }

}
 