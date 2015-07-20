<?php

namespace SMSApi\Api\Response\Contacts;

use DateTime;

final class GroupResponse extends AbstractContactsResponse implements IdentifiableResponse
{
    const FIELD_NAME = 'name';
    const FIELD_DESCRIPTION = 'description';
    const FIELD_IDX = 'idx';
    const FIELD_CONTACTS_COUNT = 'contacts_count';
    const FIELD_DATE_CREATED = 'date_created';
    const FIELD_DATE_UPDATED = 'date_updated';
    const FIELD_CREATED_BY = 'created_by';
    const FIELD_PERMISSIONS = 'permissions';

    /** @var string */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $description;

    /** @var string */
    private $idx;

    /** @var int */
    private $contactsCount;

    /** @var DateTime */
    private $dateCreated;

    /** @var DateTime */
    private $dateUpdated;

    /** @var string */
    private $createdBy;

    /** @var array */
    private $permissions;

    public function __construct(array $data)
    {
        $this->id = $data[self::FIELD_ID];
        $this->name = $data[self::FIELD_NAME];
        $this->description = $data[self::FIELD_DESCRIPTION];
        $this->idx = $data[self::FIELD_IDX];
        $this->contactsCount = $data[self::FIELD_CONTACTS_COUNT];
        $this->createdBy = $data[self::FIELD_CREATED_BY];
        $this->permissions = $data[self::FIELD_PERMISSIONS];
        $this->dateCreated = new DateTime($data[self::FIELD_DATE_CREATED]);
        $this->dateUpdated = new DateTime($data[self::FIELD_DATE_UPDATED]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getIdx()
    {
        return $this->idx;
    }

    public function getContactsCount()
    {
        return $this->contactsCount;
    }

    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    public function getPermissions()
    {
        return $this->permissions;
    }
}
