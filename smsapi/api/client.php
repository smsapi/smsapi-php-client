<?php

namespace SMSApi\Api;

class Client {

	/**
	 * @var string
	 */
	protected $username;
	/**
	 * @var string
	 */
	protected $password;

	public function __construct($username = null) {
		$this->setUsername($username);
	}

	public function setUsername($username) {
		$this->username = $username;
		return $this;
	}

	public function setPassword($password) {
		$this->password = $password;
		return $this;
	}

	public function hashPassword($password) {
		return md5($password);
	}

	public function getUsername() {
		return $this->username;
	}

	public function getPassword() {
		return $this->password;
	}
}
