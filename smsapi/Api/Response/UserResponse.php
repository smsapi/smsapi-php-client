<?php

namespace SMSApi\Api\Response;

/**
 * Class UserResponse
 * @package SMSApi\Api\AbstractContactsResponse
 */
class UserResponse extends AbstractResponse {

	/**
	 * @var string
	 */
	private $username;

	/**
	 * @var double
	 */
	private $limit;

	/**
	 * @var double
	 */
	private $monthLimit;

	/**
	 * @var
	 */
	private $senders;

	/**
	 * @var int
	 */
	private $phonebook;

	/**
	 * @var int
	 */
	private $active;

	/**
	 * @var string
	 */
	private $info;

	/**
	 * @param $data
	 */
	function __construct( $data ) {

		if ( is_object( $data ) ) {
			$this->obj = $data;
		} else if ( is_string( $data ) ) {
			parent::__construct( $data );
		}

		if ( isset( $this->obj->username ) ) {
			$this->username = $this->obj->username;
		}

		if ( isset( $this->obj->limit ) ) {
			$this->limit = $this->obj->limit;
		}

		if ( isset( $this->obj->month_limit ) ) {
			$this->monthLimit = $this->obj->month_limit;
		}

		if ( isset( $this->obj->senders ) ) {
			$this->senders = $this->obj->senders;
		}

		if ( isset( $this->obj->phonebook ) ) {
			$this->phonebook = $this->obj->phonebook;
		}

		if ( isset( $this->obj->active ) ) {
			$this->active = $this->obj->active;
		}

		if ( isset( $this->obj->info ) ) {
			$this->info = $this->obj->info;
		}
	}

	/**
	 * Returns the username used to authenticate the user.
	 *
	 * @return string The username
	 */
	public function getUsername() {
		return $this->username;
	}

	/**
	 * Returns limit points assigned to the user.
	 *
	 * @return double Points limit
	 */
	public function getLimit() {
		return $this->limit;
	}

	/**
	 * Returns number of points that will be assigned to user account each first day of month.
	 *
	 * @return double Monthly points limit
	 */
	public function getMonthLimit() {
		return $this->monthLimit;
	}

	/**
	 * @deprecated since v1.0.0 use UserResponse::hasFullAccessSenderNames
	 * @return mixed
	 */
	public function getSenders() {
		return $this->senders;
	}

	/**
	 * Returns whether the user has access to main account sender names.
	 *
	 * @return bool true if the user has access, false otherwise
	 */
	public function hasFullAccessSenderNames() {
		return (bool) $this->senders;
	}

	/**
	 * @deprecated since v1.0.0
	 * @return int
	 */
	public function getPhonebook() {
		return $this->phonebook;
	}

	/**
	 * Returns whether the user has access to main account phonebook contacts
	 *
	 * @return bool true if the user has access, false otherwise
	 */
	public function hasFullAccessPhoneBook() {
		return (bool)$this->phonebook;
	}

	/**
	 * @deprecated since v1.0.0
	 * @return int
	 */
	public function getActive() {
		return $this->active;
	}

	/**
	 * Check whether the user is enabled.
	 *
	 * @return Boolean true if the user is enabled, false otherwise
	 */
	public function isActive() {
		return (bool) $this->active;
	}

	/**
	 * Returns user description text.
	 *
	 * @return string
	 */
	public function getInfo() {
		return $this->info;
	}

}
