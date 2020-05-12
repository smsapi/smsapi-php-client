<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Contacts\Data;

use DateTimeInterface;

/**
 * @api
 */
class Contact
{
    /** @var string */
    public $id;

    /** @var string */
    public $phoneNumber;

    /** @var string */
    public $email;

    /** @var string */
    public $gender;

    /** @var string */
    public $country;

    /** @var int */
    public $undeliveredMessages;

    /** @var DateTimeInterface */
    public $dateCreated;

    /** @var DateTimeInterface */
    public $dateUpdated;

    /** @var ContactGroup[] */
    public $groups;

    /** @var ContactCustomField[] */
    public $customFields;
}
