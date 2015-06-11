<?php

namespace SMSApi\Api\Response\Contacts;

abstract class ListResponse extends AbstractContactsResponse
{
    const FIELD_SIZE = 'size';
    const FIELD_COLLECTION = 'collection';

    /** @var AbstractContactsResponse[] */
    private $collection = [];

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
