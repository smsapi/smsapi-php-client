<?php
use SMSApi\Api\ContactsFactory;
use SMSApi\Api\Response\Contacts\ContactResponse;
use SMSApi\Api\Response\Contacts\FieldResponse;
use SMSApi\Api\Response\Contacts\ListResponse;
use SMSApi\Api\Response\UserResponse;
use SMSApi\Api\UserFactory;

final class ContactsTest extends SmsapiTestCase
{
    private static $contactId = array();
    private static $groupId = array();

    /** @var ContactsFactory */
    private $contactsFactory;

    public function setUp()
    {
        $this->contactsFactory = new ContactsFactory($this->proxy, $this->client());
    }

    /**
     * @test
     */
    public function it_should_find_all_contacts_and_delete()
    {
        foreach ($this->contactsFactory->actionContactList()->execute()->getCollection() as $contact) {
            $this->assertInstanceOf(
                '\SMSApi\Api\Response\Contacts\DeleteResponse',
                $this->contactsFactory->actionContactDelete($contact->getId())->execute()
            );
        }
    }

    /**
     * @test
     * @depends it_should_find_all_contacts_and_delete
     */
    public function it_should_find_all_groups_and_delete()
    {
        foreach ($this->contactsFactory->actionGroupList()->execute()->getCollection() as $group) {
            $this->assertInstanceOf(
                '\SMSApi\Api\Response\Contacts\DeleteResponse',
                $this->contactsFactory->actionGroupDelete($group->getId())->execute()
            );
        }
    }

    /**
     * @test
     * @depends it_should_find_all_groups_and_delete
     */
    public function it_should_find_all_fields_and_delete()
    {
        foreach ($this->contactsFactory->actionFieldList()->execute()->getCollection() as $field) {
            $this->assertInstanceOf(
                '\SMSApi\Api\Response\Contacts\DeleteResponse',
                $this->contactsFactory->actionFieldDelete($field->getId())->execute()
            );
        }
    }

    /**
     * @test
     * @depends it_should_find_all_fields_and_delete
     */
    public function it_should_add_contact_from_email()
    {
        $somePhoneNumber = 48226947156;
        $someBirthdayDate = new DateTime;
        $someBirthdayDate->setTime(0, 0, 0);
        $someEmail = 'some-mail@example.com';
        $someDescription = 'some description';
        $someFirstName = 'some first name';
        $someLastName = 'some last name';
        $someCity = 'some city';
        $someSource = 'some source';
        $testedObject = $this->contactsFactory
            ->actionContactAddFromEmail($someEmail)
            ->setBirthdayDate($someBirthdayDate)
            ->setDescription($someDescription)
            ->setFirstName($someFirstName)
            ->setLastName($someLastName)
            ->setPhoneNumber($somePhoneNumber)
            ->setCity($someCity)
            ->setSource($someSource)
            ->setGenderAsMale();

        $result = $testedObject->execute();

        $this->assertInstanceOf('\SMSApi\Api\Response\Contacts\ContactResponse', $result);
        $this->assertEquals($someEmail, $result->getEmail());
        $this->assertEquals($someBirthdayDate, $result->getBirthdayDate());
        $this->assertEquals($someDescription, $result->getDescription());
        $this->assertEquals($someFirstName, $result->getFirstName());
        $this->assertEquals($someLastName, $result->getLastName());
        $this->assertEquals($somePhoneNumber, $result->getPhoneNumber());
        $this->assertEquals($someCity, $result->getCity());
        $this->assertEquals($someSource, $result->getSource());
        $this->assertEquals(ContactResponse::GENDER_MALE, $result->getGender());
        self::$contactId = $result->getId();
    }

    /**
     * @test
     * @depends it_should_add_contact_from_email
     */
    public function it_should_add_contact_from_phone_number()
    {
        $somePhoneNumber = 48226290715;
        $someBirthdayDate = new DateTime;
        $someBirthdayDate->setTime(0, 0, 0);
        $someEmail = 'another-mail@example.com';
        $someDescription = 'some description';
        $someFirstName = 'some first name';
        $someLastName = 'some last name';
        $someCity = 'some city';
        $someSource = 'some source';
        $testedObject = $this->contactsFactory
            ->actionContactAddFromPhoneNumber($somePhoneNumber)
            ->setBirthdayDate($someBirthdayDate)
            ->setDescription($someDescription)
            ->setFirstName($someFirstName)
            ->setLastName($someLastName)
            ->setEmail($someEmail)
            ->setCity($someCity)
            ->setSource($someSource)
            ->setGenderAsMale();

        $result = $testedObject->execute();

        $this->assertInstanceOf('\SMSApi\Api\Response\Contacts\ContactResponse', $result);
        $this->assertEquals($somePhoneNumber, $result->getPhoneNumber());
        $this->assertEquals($someEmail, $result->getEmail());
        $this->assertEquals($someBirthdayDate, $result->getBirthdayDate());
        $this->assertEquals($someDescription, $result->getDescription());
        $this->assertEquals($someFirstName, $result->getFirstName());
        $this->assertEquals($someLastName, $result->getLastName());
        $this->assertEquals($somePhoneNumber, $result->getPhoneNumber());
        $this->assertEquals($someCity, $result->getCity());
        $this->assertEquals($someSource, $result->getSource());
        $this->assertEquals(ContactResponse::GENDER_MALE, $result->getGender());

        return $result->getId();
    }

    /**
     * @test
     * @depends it_should_add_contact_from_phone_number
     * @param string $contactId
     * @return string
     */
    public function it_should_edit_contact($contactId)
    {
        $otherPhoneNumber = 48226952900;
        $otherBirthdayDate = new DateTime;
        $otherBirthdayDate->setTime(0, 0, 0);
        $otherEmail = 'other-mail@example.com';
        $otherDescription = 'other description';
        $otherFirstName = 'other first name';
        $otherLastName = 'other last name';
        $someCity = 'other city';
        $someSource = 'other source';
        $testedObject = $this->contactsFactory
            ->actionContactEdit($contactId)
            ->setEmail($otherEmail)
            ->setBirthdayDate($otherBirthdayDate)
            ->setDescription($otherDescription)
            ->setFirstName($otherFirstName)
            ->setLastName($otherLastName)
            ->setPhoneNumber($otherPhoneNumber)
            ->setCity($someCity)
            ->setSource($someSource)
            ->setGenderAsFemale();

        $result = $testedObject->execute();

        $this->assertInstanceOf('\SMSApi\Api\Response\Contacts\ContactResponse', $result);
        $this->assertEquals($otherPhoneNumber, $result->getPhoneNumber());
        $this->assertEquals($otherEmail, $result->getEmail());
        $this->assertEquals($otherBirthdayDate, $result->getBirthdayDate());
        $this->assertEquals($otherDescription, $result->getDescription());
        $this->assertEquals($otherFirstName, $result->getFirstName());
        $this->assertEquals($otherLastName, $result->getLastName());
        $this->assertEquals($otherPhoneNumber, $result->getPhoneNumber());
        $this->assertEquals($someCity, $result->getCity());
        $this->assertEquals($someSource, $result->getSource());
        $this->assertEquals(ContactResponse::GENDER_FEMALE, $result->getGender());

        return $contactId;
    }

    /**
     * @test
     * @depends it_should_edit_contact
     * @param string $contactId
     */
    public function it_should_get_contact($contactId)
    {
        $testedObject = $this->contactsFactory->actionContactGet($contactId);

        $result = $testedObject->execute();

        $this->assertInstanceOf('\SMSApi\Api\Response\Contacts\ContactResponse', $result);
        $this->assertEquals($contactId, $result->getId());
    }

    /**
     * @test
     * @depends it_should_get_contact
     */
    public function it_should_add_group()
    {
        $someName = 'some group name';
        $testedObject = $this->contactsFactory
            ->actionGroupAdd($someName)
            ->setDescription('some description')
            ->setIdx('some idx');

        $result = $testedObject->execute();

        $this->assertInstanceOf('\SMSApi\Api\Response\Contacts\GroupResponse', $result);
        $this->assertEquals($someName, $result->getName());
        self::$groupId = $result->getId();

        return $result->getId();
    }

    /**
     * @test
     * @depends it_should_add_group
     * @param string $groupId
     * @return string
     */
    public function it_should_edit_group($groupId)
    {
        $testedObject = $this->contactsFactory->actionGroupEdit($groupId);

        $result = $testedObject
            ->setName('some name')
            ->setDescription('some description')
            ->setIdx('some idx')
            ->execute();

        $this->assertInstanceOf('\SMSApi\Api\Response\Contacts\GroupResponse', $result);
        $this->assertEquals($groupId, $result->getId());

        return $groupId;
    }

    /**
     * @test
     * @depends it_should_edit_group
     * @param string $groupId
     */
    public function it_should_get_group($groupId)
    {
        $testedObject = $this->contactsFactory->actionGroupGet($groupId);

        $result = $testedObject->execute();

        $this->assertInstanceOf('\SMSApi\Api\Response\Contacts\GroupResponse', $result);
        $this->assertEquals($groupId, $result->getId());
    }

    /**
     * @test
     * @depends it_should_get_group
     */
    public function it_should_add_contact_group()
    {
        $someGroupId = self::$groupId;
        $testedObject = $this->contactsFactory->actionContactGroupAdd(self::$contactId, $someGroupId);

        $result = $testedObject->execute();

        $this->assertListResponse('\SMSApi\Api\Response\Contacts\GroupsResponse', array($someGroupId), $result);
    }

    /**
     * @test
     * @depends it_should_add_contact_group
     */
    public function it_should_get_contact_group()
    {
        $someGroupId = self::$groupId;
        $testedObject = $this->contactsFactory->actionContactGroupGet(self::$contactId, $someGroupId);

        $result = $testedObject->execute();

        $this->assertInstanceOf('\SMSApi\Api\Response\Contacts\GroupResponse', $result);
        $this->assertEquals($someGroupId, $result->getId());
    }

    /**
     * @test
     * @depends it_should_get_contact_group
     */
    public function it_should_add_group_permission()
    {
        $username = $this->getSubuserUsername();
        $groupId = self::$groupId;
        $testedObject = $this->contactsFactory
            ->actionGroupPermissionAdd($groupId, $username)
            ->enableRead()
            ->enableSend()
            ->enableWrite();

        $result = $testedObject->execute();

        $this->assertInstanceOf('\SMSApi\Api\Response\Contacts\PermissionResponse', $result);
        $this->assertTrue($result->getRead());
        $this->assertTrue($result->getSend());
        $this->assertTrue($result->getWrite());
        $this->assertEquals($username, $result->getUsername());
        $this->assertEquals($groupId, $result->getGroupId());
    }

    /**
     * @test
     * @depends it_should_add_group_permission
     */
    public function it_should_edit_group_permission()
    {
        $username = $this->getSubuserUsername();
        $groupId = self::$groupId;
        $testedObject = $this->contactsFactory
            ->actionGroupPermissionEdit($groupId, $username)
            ->disableRead()
            ->disableSend()
            ->disableWrite();

        $result = $testedObject->execute();

        $this->assertInstanceOf('\SMSApi\Api\Response\Contacts\PermissionResponse', $result);
        $this->assertFalse($result->getRead());
        $this->assertFalse($result->getSend());
        $this->assertFalse($result->getWrite());
        $this->assertEquals($username, $result->getUsername());
        $this->assertEquals($groupId, $result->getGroupId());
    }

    /**
     * @test
     * @depends it_should_edit_group_permission
     */
    public function it_should_get_group_permission()
    {
        $username = $this->getSubuserUsername();
        $groupId = self::$groupId;
        $testedObject = $this->contactsFactory->actionGroupPermissionGet($groupId, $username);

        $result = $testedObject->execute();

        $this->assertInstanceOf('\SMSApi\Api\Response\Contacts\PermissionResponse', $result);
        $this->assertEquals($username, $result->getUsername());
        $this->assertEquals($groupId, $result->getGroupId());
    }

    /**
     * @test
     * @depends it_should_edit_group_permission
     */
    public function it_should_list_group_permission()
    {
        $groupId = self::$groupId;
        $testedObject = $this->contactsFactory->actionGroupPermissionList($groupId);

        $result = $testedObject->execute();

        $this->assertInstanceOf('\SMSApi\Api\Response\Contacts\PermissionsResponse', $result);
        $this->assertEquals(2, $result->getSize());
        $collection = $result->getCollection();
        $this->assertEquals($groupId, $collection[0]->getGroupId());
    }

    /**
     * @test
     * @depends it_should_get_group_permission
     */
    public function it_should_add_group_member()
    {
        $contactId = self::$contactId;
        $testedObject = $this->contactsFactory->actionGroupMemberAdd(self::$groupId, $contactId);

        $result = $testedObject->execute();

        $this->assertInstanceOf('\SMSApi\Api\Response\Contacts\ContactResponse', $result);
        $this->assertEquals($contactId, $result->getId());
    }

    /**
     * @test
     * @depends it_should_add_group_member
     */
    public function it_should_get_group_member()
    {
        $contactId = self::$contactId;
        $testedObject = $this->contactsFactory->actionGroupMemberGet(self::$groupId, $contactId);

        $result = $testedObject->execute();

        $this->assertInstanceOf('\SMSApi\Api\Response\Contacts\ContactResponse', $result);
        $this->assertEquals($contactId, $result->getId());
    }

    /**
     * @test
     * @depends it_should_get_group_member
     */
    public function it_should_add_field()
    {
        $someName = 'some name';
        $testedObject = $this->contactsFactory
            ->actionFieldAdd($someName)
            ->setTypeAsDate();

        $result = $testedObject->execute();

        $this->assertInstanceOf('\SMSApi\Api\Response\Contacts\FieldResponse', $result);
        $this->assertEquals($someName, $result->getName());
        $this->assertEquals(FieldResponse::TYPE_DATE, $result->getType());

        return $result->getId();
    }

    /**
     * @test
     * @depends it_should_add_field
     * @param string $fieldId
     * @return string
     */
    public function it_should_edit_field($fieldId)
    {
        $newName = 'new name';
        $testedObject = $this->contactsFactory
            ->actionFieldEdit($fieldId)
            ->setName($newName)
            ->setTypeAsEmail();

        $result = $testedObject->execute();

        $this->assertInstanceOf('\SMSApi\Api\Response\Contacts\FieldResponse', $result);
        $this->assertEquals($fieldId, $result->getId());
        $this->assertEquals($newName, $result->getName());
        $this->assertEquals(FieldResponse::TYPE_EMAIL, $result->getType());

        return $fieldId;
    }

    private function assertListResponse($expectedInstance, $expectedIds, ListResponse $testedList)
    {
        $this->assertInstanceOf($expectedInstance, $testedList);
        $this->assertEquals(count($expectedIds), $testedList->getSize());
        $ids = array();
        foreach ($testedList->getCollection() as $element) {
            $ids[] = $element->getId();
        }
        foreach ($expectedIds as $element) {
            $this->assertContains($element, $ids);
        }
    }

    private function getSubuserUsername()
    {
        $userFactory = new UserFactory($this->proxy, $this->client());

        /** @var UserResponse[] $subusers */
        $subusers = $userFactory->actionList()->execute()->getList();

        return $subusers[0]->getUsername();
    }
}