<?php

namespace SMSApi\Api\Action\Contacts;

use SMSApi\Api\Action\AbstractAction;
use SMSApi\Client;
use SMSApi\Proxy\Proxy;
use SMSApi\Proxy\Uri;

abstract class ContactsAction extends AbstractAction
{
    protected $isContacts = true;

    public function __construct(Client $client, Proxy $proxy)
    {
        parent::__construct();

        $this
            ->client($client)
            ->proxy($proxy);
    }

    public function uri()
    {
        return new Uri(
            $this->proxy->getProtocol(),
            $this->proxy->getHost(),
            $this->proxy->getPort(),
            $this->getResource(),
            $this->paramsLoginToQuery() . $this->paramsOther()
        );
    }

    /**
     * @return string
     */
    abstract protected function getResource();
}
