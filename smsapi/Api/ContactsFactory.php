<?php

namespace SMSApi\Api;

use SMSApi\Api\Action\Contacts\ContactAddByEmail;
use SMSApi\Api\Action\Contacts\ContactAddByFirstName;
use SMSApi\Api\Action\Contacts\ContactAddByLastName;
use SMSApi\Api\Action\Contacts\ContactAddByPhoneNumber;
use SMSApi\Api\Action\Contacts\ContactsDelete;
use SMSApi\Api\Action\Contacts\ContactsEdit;
use SMSApi\Api\Action\Contacts\ContactsGet;
use SMSApi\Api\Action\Contacts\ContactsGroupAdd;
use SMSApi\Api\Action\Contacts\ContactsGroupDelete;
use SMSApi\Api\Action\Contacts\ContactsGroupGet;
use SMSApi\Api\Action\Contacts\ContactsGroupList;
use SMSApi\Api\Action\Contacts\ContactsList;
use SMSApi\Api\Action\Contacts\FieldAdd;
use SMSApi\Api\Action\Contacts\FieldDelete;
use SMSApi\Api\Action\Contacts\FieldEdit;
use SMSApi\Api\Action\Contacts\FieldGet;
use SMSApi\Api\Action\Contacts\FieldList;
use SMSApi\Api\Action\Contacts\FieldOptionList;
use SMSApi\Api\Action\Contacts\GroupAdd;
use SMSApi\Api\Action\Contacts\GroupDelete;
use SMSApi\Api\Action\Contacts\GroupEdit;
use SMSApi\Api\Action\Contacts\GroupGet;
use SMSApi\Api\Action\Contacts\GroupList;
use SMSApi\Api\Action\Contacts\GroupMemberDelete;
use SMSApi\Api\Action\Contacts\GroupMemberAdd;
use SMSApi\Api\Action\Contacts\GroupMemberGet;
use SMSApi\Api\Action\Contacts\GroupPermissionAdd;
use SMSApi\Api\Action\Contacts\GroupPermissionDelete;
use SMSApi\Api\Action\Contacts\GroupPermissionEdit;
use SMSApi\Api\Action\Contacts\GroupPermissionGet;
use SMSApi\Api\Action\Contacts\GroupPermissionList;

final class ContactsFactory extends ActionFactory
{
    public function actionContactList()
    {
        return new ContactsList($this->client, $this->proxy);
    }

    public function actionContactGet($contactId)
    {
        return new ContactsGet($contactId, $this->client, $this->proxy);
    }

    public function actionContactAddFromFirstName($firstName)
    {
        return new ContactAddByFirstName($firstName, $this->client, $this->proxy);
    }

    public function actionContactAddFromLastName($lastName)
    {
        return new ContactAddByLastName($lastName, $this->client, $this->proxy);
    }

    public function actionContactAddFromEmail($email)
    {
        return new ContactAddByEmail($email, $this->client, $this->proxy);
    }

    public function actionContactAddFromPhoneNumber($phoneNumber)
    {
        return new ContactAddByPhoneNumber($phoneNumber, $this->client, $this->proxy);
    }

    public function actionContactEdit($contactId)
    {
        return new ContactsEdit($contactId, $this->client, $this->proxy);
    }

    public function actionContactDelete($contactId)
    {
        return new ContactsDelete($contactId, $this->client, $this->proxy);
    }

    public function actionContactGroupList($contactId)
    {
        return new ContactsGroupList($contactId, $this->client, $this->proxy);
    }

    public function actionContactGroupGet($contactId, $groupId)
    {
        return new ContactsGroupGet($contactId, $groupId, $this->client, $this->proxy);
    }

    public function actionContactGroupEdit($contactId, $groupId)
    {
        return new ContactsGroupAdd($contactId, $groupId, $this->client, $this->proxy);
    }

    public function actionContactGroupDelete($contactId, $groupId)
    {
        return new ContactsGroupDelete($contactId, $groupId, $this->client, $this->proxy);
    }

    public function actionGroupList()
    {
        return new GroupList($this->client, $this->proxy);
    }

    public function actionGroupGet($groupId)
    {
        return new GroupGet($groupId, $this->client, $this->proxy);
    }

    public function actionGroupAdd($groupName)
    {
        return new GroupAdd($groupName, $this->client, $this->proxy);
    }

    public function actionGroupEdit($groupId)
    {
        return new GroupEdit($groupId, $this->client, $this->proxy);
    }

    public function actionGroupDelete($groupId)
    {
        return new GroupDelete($groupId, $this->client, $this->proxy);
    }

    public function actionGroupPermissionList($groupId)
    {
        return new GroupPermissionList($groupId, $this->client, $this->proxy);
    }

    public function actionGroupPermissionGet($groupId, $username)
    {
        return new GroupPermissionGet($groupId, $username, $this->client, $this->proxy);
    }

    public function actionGroupPermissionAdd($groupId, $username)
    {
        return new GroupPermissionAdd($groupId, $username, $this->client, $this->proxy);
    }

    public function actionGroupPermissionEdit($groupId, $username)
    {
        return new GroupPermissionEdit($groupId, $username, $this->client, $this->proxy);
    }

    public function actionGroupPermissionDelete($groupId, $username)
    {
        return new GroupPermissionDelete($groupId, $username, $this->client, $this->proxy);
    }

    public function actionGroupMemberGet($groupId, $contactId)
    {
        return new GroupMemberGet($groupId, $contactId, $this->client, $this->proxy);
    }

    public function actionGroupMemberEdit($groupId, $contactId)
    {
        return new GroupMemberAdd($groupId, $contactId, $this->client, $this->proxy);
    }

    public function actionGroupMemberDelete($groupId, $contactId)
    {
        return new GroupMemberDelete($groupId, $contactId, $this->client, $this->proxy);
    }
    public function actionFieldList()
    {
        return new FieldList($this->client, $this->proxy);
    }

    public function actionFieldGet($fieldId)
    {
        return new FieldGet($fieldId, $this->client, $this->proxy);
    }

    public function actionFieldAdd($name)
    {
        return new FieldAdd($name, $this->client, $this->proxy);
    }

    public function actionFieldEdit($fieldId)
    {
        return new FieldEdit($fieldId, $this->client, $this->proxy);
    }

    public function actionFieldDelete($fieldId)
    {
        return new FieldDelete($fieldId, $this->client, $this->proxy);
    }

    public function actionFieldOptionList($fieldId)
    {
        return new FieldOptionList($fieldId, $this->client, $this->proxy);
    }
}
