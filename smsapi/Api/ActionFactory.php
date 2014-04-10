<?php

namespace SMSApi\Api;

/**
 * Class ActionFactory
 * @package SMSApi\Api
 */
abstract class ActionFactory {

	/**
	 * @var \SMSApi\Client
	 */
	protected $client = null;

	/**
	 * @var \SMSApi\Proxy\Proxy
	 */
	protected $proxy = null;

	/**
	 * @param null $proxy
	 * @param null $client
	 */
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

	/**
	 * @param \SMSApi\Client $client
	 * @return $this
	 */
	public function setClient( \SMSApi\Client $client ) {
		$this->client = $client;
		return $this;
	}

	/**
	 * @param \SMSApi\Proxy\Proxy $proxy
	 * @return $this
	 */
	public function setProxy( \SMSApi\Proxy\Proxy $proxy ) {
		$this->proxy = $proxy;
		return $this;
	}

	/**
	 * @return \SMSApi\Client
	 */
	public function getClient() {
		return $this->client;
	}

	/**
	 * @return \SMSApi\Proxy\Proxy
	 */
	public function getProxy() {
		return $this->proxy;
	}

}
