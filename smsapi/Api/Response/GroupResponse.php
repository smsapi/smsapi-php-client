<?php

namespace SMSApi\Api\Response;

class GroupResponse extends AbstractResponse {

	private $name = null;
	private $info = null;
	private $numbers = null;

	function __construct( $data ) {

		if ( is_object( $data ) ) {
			$this->obj = $data;
		} else if ( is_string( $data ) ) {
			parent::__construct( $data );
		}

		if ( isset( $this->obj->name ) ) {
			$this->name = $this->obj->name;
		}

		if ( isset( $this->obj->info ) ) {
			$this->info = $this->obj->info;
		}

		if ( isset( $this->obj->numbers_count ) ) {
			$this->numbers = $this->obj->numbers_count;
		}
	}

	public function getName() {
		return $this->name;
	}

	public function getInfo() {
		return $this->info;
	}

	public function getNumbers() {
		return $this->numbers;
	}

}
