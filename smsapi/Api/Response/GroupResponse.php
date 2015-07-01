<?php

namespace SMSApi\Api\Response;

/**
 * Class GroupResponse
 * @package SMSApi\Api\AbstractContactsResponse
 * @deprecated use Contacts\GroupResponse
 */
class GroupResponse extends AbstractResponse {

	/**
	 * @var string
	 */
	private $name = null;
	/**
	 * @var string
	 */
	private $info = null;
	/**
	 * @var array
	 */
	private $numbers_count = null;

	/**
	 * @param $data
	 */
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
			$this->numbers_count = $this->obj->numbers_count;
		}
	}

	/**
	 * Returns group name
	 *
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Returns group information
	 *
	 * @return string
	 */
	public function getInfo() {
		return $this->info;
	}

	/**
	 * @deprecated since v1.0.0 use GroupResponse::getNumbersCount
	 * @return null
	 */
	public function getNumbers() {
		return $this->numbers_count;
	}

	/**
	 * Returns count numbers in group
	 *
	 * @return int
	 */
	public function getNumbersCount() {
		return $this->numbers_count;
	}

}
