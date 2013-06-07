<?php

namespace SMSApi\Api\Response;

class RawResponse implements Response {

	private $text;

	function __construct( $data ) {

		$this->text = $data;
	}

	public function getText() {
		return $this->text;
	}

}

