<?php

namespace SMSApi\Api\Response;

class SenderResponse extends AbstractResponse {

	private $name;
	private $status;
	private $setDefault;

	function __construct( $data ) {

		if ( is_object( $data ) ) {
			$this->obj = $data;
		} else if ( is_string( $data ) ) {
			parent::__construct( $data );
		}

		if ( isset( $this->obj->sender ) ) {
			$this->name = $this->obj->sender;
		}

		if ( isset( $this->obj->status ) ) {
			$this->status = $this->obj->status;
		}

		if ( isset( $this->obj->default ) ) {
			$this->setDefault = $this->obj->default;
		}
	}

	public function isDefault() {
		return ($this->setDefault != null && $this->setDefault == "default");
	}

	public function getName() {
		return $this->name;
	}

	public function getStatus() {
		return $this->status;
	}

}
