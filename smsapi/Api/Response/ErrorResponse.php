<?php

namespace SMSApi\Api\Response;

/**
 * Class ErrorResponse
 * @package SMSApi\Api\AbstractContactsResponse
 */
class ErrorResponse extends AbstractResponse {

	/**
	 * @var int
	 */
	public $code = 0;
	/**
	 * @var string
	 */
	public $message = "";

	/**
	 * @param $data
	 */
	function __construct( $data ) {
		parent::__construct( $data );

		if ( isset( $this->obj->error ) ) {
			$this->code = $this->obj->error;
		}

		if ( isset( $this->obj->message ) ) {
			$this->message = $this->obj->message;
		}
	}

	/**
	 * @return bool
	 */
	public function isError() {
		return ($this->code != 0);
	}

}

