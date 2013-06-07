<?php

namespace SMSApi\Proxy;

interface Proxy {

	public function execute( \SMSApi\Api\Action\AbstractAction $action );

	public function getProtocol();

	public function getHost();

	public function getPort();
}