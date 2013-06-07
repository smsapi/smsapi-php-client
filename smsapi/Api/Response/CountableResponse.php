<?php

namespace SMSApi\Api\Response;

class CountableResponse extends AbstractResponse {

	protected $count;

	function __construct( $data ) {
		parent::__construct( $data );

		$this->count = isset( $this->obj->count ) ? $this->obj->count : 0;
	}

	public function getCount() {
		return $this->count;
	}

}

