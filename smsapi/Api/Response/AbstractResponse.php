<?php

namespace SMSApi\Api\Response;

abstract class AbstractResponse implements Response {

	protected $obj;

	function __construct( $data ) {
		$this->obj = $this->decode($data);
	}

	protected function decode($string) {

		$result = json_decode($string);

		if( $result === null ) {
			throw new \SMSApi\Exception\SmsapiException("error json: ".json_last_error());
		}

		return $result;
	}

}
