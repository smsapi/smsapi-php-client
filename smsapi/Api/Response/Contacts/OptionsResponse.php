<?php

namespace SMSApi\Api\Response\Contacts;

/**
 * @method OptionResponse[] getCollection()
 */
final class OptionResponse extends ListResponse
{
    protected function createItem(array $item)
    {
        return new OptionResponse($item);
    }
}
