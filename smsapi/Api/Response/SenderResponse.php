<?php

namespace SMSApi\Api\Response;

/**
 * Class SenderResponse
 * @package SMSApi\Api\AbstractContactsResponse
 */
class SenderResponse extends AbstractResponse {

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var string
	 */
	private $status;

	/**
	 * @var int
	 */
	private $default;

	/**
	 * @param $data
	 */
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

	/**
	 * Is sender name is default selected.
	 *
	 * @return bool
	 */
	public function isDefault() {
		return (bool)$this->default;
	}

	/**
	 * Returns sender name.
	 *
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Returns status sender name.
	 *
	 * Example:
	 * ACTIVE INACTIVE
	 *
	 * @return string
	 */
	public function getStatus() {
		return $this->status;
	}

}
