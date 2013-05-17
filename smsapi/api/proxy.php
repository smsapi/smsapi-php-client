<?php

namespace SMSApi\Api;

interface Proxy {

	public function execute($uri, array $data, array $files = array());
}