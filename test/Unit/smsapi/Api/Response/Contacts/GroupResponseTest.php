<?php

namespace SMSApi\Api\Response\Contacts;

use PHPUnit_Framework_TestCase;

class GroupResponseTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_set_date_created_if_is_not_empty()
    {
        $notEmptyDateCreated = '2015-06-09T14:57:00+02:00';
        $testedObject = $this->createGroupResponseWithDateCreated($notEmptyDateCreated);

        $result = $testedObject->getDateCreated();

        $this->assertNotNull($result);
    }

    /**
     * @test
     */
    public function it_should_not_set_date_created_if_is_empty()
    {
        $emptyDateCreated = null;
        $testedObject = $this->createGroupResponseWithDateCreated($emptyDateCreated);

        $result = $testedObject->getDateCreated();

        $this->assertNull($result);
    }

    /**
     * @test
     */
    public function it_should_set_date_updated_if_is_not_empty()
    {
        $notEmptyDateUpdated = '2015-06-09T14:57:00+02:00';
        $testedObject = $this->createGroupResponseWithDateUpdated($notEmptyDateUpdated);

        $result = $testedObject->getDateUpdated();

        $this->assertNotNull($result);
    }

    /**
     * @test
     */
    public function it_should_not_set_date_updated_if_is_empty()
    {
        $emptyDateUpdated = null;
        $testedObject = $this->createGroupResponseWithDateUpdated($emptyDateUpdated);

        $result = $testedObject->getDateUpdated();

        $this->assertNull($result);
    }

    private function createGroupResponseWithDateCreated($dateCreated)
    {
        return self::createGroupResponse($dateCreated, null);
    }

    private function createGroupResponseWithDateUpdated($dateUpdated)
    {
        return self::createGroupResponse(null, $dateUpdated);
    }

    private function createGroupResponse($dateCreated, $dateUpdated)
    {
        return new GroupResponse(
            array(
                GroupResponse::FIELD_ID => 1,
                GroupResponse::FIELD_NAME => 'some name',
                GroupResponse::FIELD_DESCRIPTION => null,
                GroupResponse::FIELD_IDX => null,
                GroupResponse::FIELD_CONTACTS_COUNT => 0,
                GroupResponse::FIELD_DATE_CREATED => $dateCreated,
                GroupResponse::FIELD_DATE_UPDATED => $dateUpdated,
                GroupResponse::FIELD_CREATED_BY => 'some username',
                GroupResponse::FIELD_PERMISSIONS => array(),
            )
        );
    }
}
