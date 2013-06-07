<?php

namespace SMSApi\Api\Response;

abstract class AbstractResponse implements Response {

	protected $obj;

	function __construct( $data ) {
		$this->obj = json_decode( $data );
	}

}
