<?php

namespace SMSApi\Api\Response;

/**
 * Class RawResponse
 * @package SMSApi\Api\AbstractContactsResponse
 */
class RawResponse implements Response {

	/**
	 * @var
	 */
	private $text;

	/**
	 * @param $data
	 */
	function __construct( $data ) {

		$this->text = $data;
	}

	/**
	 * @return mixed
	 */
	public function getText() {
		return $this->text;
	}

}

