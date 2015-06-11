<?php

namespace SMSApi\Api\Response;

/**
 * Class AbstractResponse
 * @package SMSApi\Api\AbstractContactsResponse
 */
abstract class AbstractResponse implements Response {

	/**
	 * @var mixed
	 */
	protected $obj;

	/**
	 * @param $data
	 */
	function __construct( $data ) {
		$this->obj = $this->decode($data);
	}

	/**
	 * @param $string
	 * @return mixed
	 * @throws \SMSApi\Exception\SmsapiException
	 */
	protected function decode($string) {

		$result = json_decode($string);

		if( $result === null ) {
			throw new \SMSApi\Exception\SmsapiException("error json: ".json_last_error());
		}

		return $result;
	}

}
