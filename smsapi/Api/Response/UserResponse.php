<?php

namespace SMSApi\Api\Response;

class UserResponse extends AbstractResponse {

	private $username;
	private $limit;
	private $monthLimit;
	private $senders;
	private $phonebook;
	private $active;
	private $info;

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

	public function getUsername() {
		return $this->username;
	}

	public function getLimit() {
		return $this->limit;
	}

	public function getMonthLimit() {
		return $this->monthLimit;
	}

	public function getSenders() {
		return $this->senders;
	}

	public function getPhonebook() {
		return $this->phonebook;
	}

	public function getActive() {
		return $this->active;
	}

	public function getInfo() {
		return $this->info;
	}

}
