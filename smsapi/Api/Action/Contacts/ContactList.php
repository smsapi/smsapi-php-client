<?php

namespace SMSApi\Api\Action\Contacts;

use DateTime;
use SMSApi\Api\Response\Contacts\ContactResponse;
use SMSApi\Api\Response\Contacts\ContactsResponse;

/**
 * @method ContactsResponse execute()
 */
final class ContactList extends ContactCount
{
    const PARAM_OFFSET = 'offset';
    const PARAM_LIMIT = 'limit';
    const PARAM_ORDER_BY = 'order_by';

    public function getMethod()
    {
        return self::METHOD_GET;
    }

    protected function response($data)
    {
        return ContactsResponse::fromJsonString($data);
    }

    public function setOffsetAndLimit($offset, $limit)
    {
        $this
            ->setParamValue(self::PARAM_OFFSET, $offset)
            ->setParamValue(self::PARAM_LIMIT, $limit);

        return $this;
    }

    public function setOrderBy($orderBy)
    {
        $this->setParamValue(self::PARAM_ORDER_BY, $orderBy);

        return $this;
    }
}
