<?php

namespace SMSApi;

use SMSApi\Exception\ClientException;

class Client {

	private $username;
	private $password;

	public function __construct( $username ) {
		$this->setUsername( $username );
	}

	public function setUsername( $username ) {

		if ( empty( $username ) ) {
			throw new ClientException( "Username can not be empty" );
		}

		$this->username = $username;
		return $this;
	}

	public function setPasswordHash( $password ) {

		if ( empty( $password ) ) {
			throw new ClientException( "Password can not be empty" );
		}

		$this->password = $password;
		return $this;
	}

	public function setPasswordRaw( $password ) {
		$this->setPasswordHash( md5( $password ) );
		return $this;
	}

	public function getUsername() {
		return $this->username;
	}

	public function getPassword() {
		return $this->password;
	}

}
