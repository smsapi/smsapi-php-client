<?php

namespace SMSApi\Api;

use SMSApi\Api\Action\Contacts\ContactDeleteMultiple;
use SMSApi\Api\Action\Contacts\ContactAddByEmail;
use SMSApi\Api\Action\Contacts\ContactAddByPhoneNumber;
use SMSApi\Api\Action\Contacts\ContactCount;
use SMSApi\Api\Action\Contacts\ContactDelete;
use SMSApi\Api\Action\Contacts\ContactEdit;
use SMSApi\Api\Action\Contacts\ContactGet;
use SMSApi\Api\Action\Contacts\ContactGroupAdd;
use SMSApi\Api\Action\Contacts\ContactGroupDelete;
use SMSApi\Api\Action\Contacts\ContactGroupGet;
use SMSApi\Api\Action\Contacts\ContactGroupList;
use SMSApi\Api\Action\Contacts\ContactList;
use SMSApi\Api\Action\Contacts\FieldAdd;
use SMSApi\Api\Action\Contacts\FieldDelete;
use SMSApi\Api\Action\Contacts\FieldEdit;
use SMSApi\Api\Action\Contacts\FieldList;
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
        return new ContactList($this->client, $this->proxy);
    }

    public function actionContactCount()
    {
        return new ContactCount($this->client, $this->proxy);
    }

    public function actionContactGet($contactId)
    {
        return new ContactGet($contactId, $this->client, $this->proxy);
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
        return new ContactEdit($contactId, $this->client, $this->proxy);
    }

    public function actionContactDelete($contactId)
    {
        return new ContactDelete($contactId, $this->client, $this->proxy);
    }

    public function actionContactDeleteMultiple()
    {
        return new ContactDeleteMultiple($this->client, $this->proxy);
    }

    public function actionContactGroupList($contactId)
    {
        return new ContactGroupList($contactId, $this->client, $this->proxy);
    }

    public function actionContactGroupGet($contactId, $groupId)
    {
        return new ContactGroupGet($contactId, $groupId, $this->client, $this->proxy);
    }

    public function actionContactGroupAdd($contactId, $groupId)
    {
        return new ContactGroupAdd($contactId, $groupId, $this->client, $this->proxy);
    }

    public function actionContactGroupDelete($contactId, $groupId)
    {
        return new ContactGroupDelete($contactId, $groupId, $this->client, $this->proxy);
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

    public function actionGroupMemberAdd($groupId, $contactId)
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
}
