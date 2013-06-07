<?php

namespace SMSApi\Api\Response;

class ErrorResponse extends AbstractResponse {

	public $code = 0;
	public $message = "";

	function __construct( $data ) {
		parent::__construct( $data );

		if ( isset( $this->obj->error ) ) {
			$this->code = $this->obj->error;
		}

		if ( isset( $this->obj->message ) ) {
			$this->message = $this->obj->message;
		}
	}

	public function isError() {
		return ($this->code != 0);
	}

}

