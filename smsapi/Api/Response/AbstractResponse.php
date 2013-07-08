<?php

namespace SMSApi\Api\Response;

abstract class AbstractResponse implements Response {

	protected $obj;

	function __construct( $data ) {
		$this->obj = json_decode( $data );
		
		if($this->obj === null){
			throw new \SMSApi\Exception\SmsapiException("error json: ".json_last_error());
		}
		
	}

}
