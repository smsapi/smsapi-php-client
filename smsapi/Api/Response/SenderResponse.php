<?php

namespace SMSApi\Api\Response;

class SenderResponse extends AbstractResponse {

	private $name;
	private $status;
	private $default;

	function __construct( $data ) {

		if ( is_object( $data ) ) {
			$this->obj = $data;
		} else if ( is_string( $data ) ) {
			parent::__construct( $data );
		}

		if( isset( $this->obj->sender ) ) {
			$this->name = $this->obj->sender;
		}

		if( isset( $this->obj->status ) ) {
			$this->status = $this->obj->status;
		}

		if( isset( $this->obj->default ) ) {
			$this->default = $this->obj->default;
		}
	}

	public function isDefault() {
		return (bool)$this->default;
	}

	public function getName() {
		return $this->name;
	}

	public function getStatus() {
		return $this->status;
	}

}
