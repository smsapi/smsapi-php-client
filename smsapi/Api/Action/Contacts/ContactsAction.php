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
            ->proxy($proxy->setBasicAuthentication($client));
    }

    public function uri()
    {
        return new Uri(
            $this->proxy->getProtocol(),
            $this->proxy->getHost(),
            $this->proxy->getPort(),
            $this->getResource(),
            ltrim($this->setJson(false)->paramsOther(), '&')
        );
    }

    protected function setParamValue($name, $value)
    {
        $this->params[$name] = urlencode($value);

        return $this;
    }

    protected function setParamArray($name, array $values)
    {
        $this->params[$name] = array_map('urlencode', $values);

        return $this;
    }

    /**
     * @return string
     */
    abstract protected function getResource();
}
