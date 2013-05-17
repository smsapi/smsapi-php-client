<?php

namespace SMSApi\Api;

abstract class AbstractFactory {

	/**
	 * @var null|\SMSApi\Api\Client
	 */
	protected $client = null;

	protected $proxy = null;

	public function __construct(\SMSApi\Api\Client $client = null) {

		$this->client( $client );
		$this->proxy( new \SMSApi\Api\Proxy\Native('https://ssl.smsapi.pl/api/') );
	}

	public function client(\SMSApi\Api\Client $client = null) {
		$this->client = $client;
		return $this;
	}

	public function proxy(\SMSApi\Api\Proxy $proxy) {
		$this->proxy = $proxy;
		return $this;
	}
}
