<?php

namespace SMSApi\Api;

abstract class ActionFactory {

	protected $client = null;
	protected $proxy = null;

	public function __construct( $proxy = null, $client = null ) {

		if ( $proxy instanceof \SMSApi\Proxy\Proxy ) {
			$this->setProxy( $proxy );
		} else {
			$this->setProxy( new \SMSApi\Proxy\Http\Native( 'https://ssl.smsapi.pl/' ) );
		}

		if ( $client instanceof \SMSApi\Client ) {
			$this->setClient( $client );
		}
	}

	public function setClient( \SMSApi\Client $client ) {
		$this->client = $client;
		return $this;
	}

	public function setProxy( \SMSApi\Proxy\Proxy $proxy ) {
		$this->proxy = $proxy;
		return $this;
	}

	public function getClient() {
		return $this->client;
	}

	public function getProxy() {
		return $this->proxy;
	}

}
