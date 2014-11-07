<?php

namespace SMSApi\Api\Response;


class ContactResponseTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @expectedException \SMSApi\Exception\InvalidParameterException
     * @expectedExceptionMessage Use action \SMSApi\Api\Action\Phonebook\ContactGet::withGroups() method to load resources with groups
     */
    public function testExceptionWhenGroupsIsNotLoaded()
    {

        $data = array();

        $contactResponse = new ContactResponse($data);

        $contactResponse->getGroups();

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
 