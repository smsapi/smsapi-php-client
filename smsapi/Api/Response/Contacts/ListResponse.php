<?php

namespace SMSApi\Api\Response\Contacts;

abstract class ListResponse extends AbstractContactsResponse implements CountableResponse
{
    const FIELD_COLLECTION = 'collection';

    /** @var IdentifiableResponse[] */
    private $collection = array();

    /** @var int */
    private $size;

    function __construct(array $data)
    {
        $this->size = $data[self::FIELD_SIZE];

        foreach ($data[self::FIELD_COLLECTION] as $contact) {
            $this->collection[] = $this->createItem($contact);
        }
    }

    /**
     * @param array $item
     * @return AbstractContactsResponse
     */
    abstract protected function createItem(array $item);

    public function getSize()
    {
        return $this->size;
    }

    public function getCollection()
    {
        return $this->collection;
    }
}
