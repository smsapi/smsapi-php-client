<?php

namespace SMSApi;

use SMSApi\Exception\ClientException;

/**
 * Class Client
 * @package SMSApi
 */
class Client {
    const VERSION = '1.8.7';

	/**
	 * @var string
	 */
	private $username;

	/**
	 * @var string
	 */
	private $password;

    /** @var string */
    private $token;

    public static function createFromToken($token)
    {
        $client = new static('no username');
        $client->setToken($token);

        return $client;
    }

	/**
	 * @param $username
	 */
	public function __construct( $username ) {
		$this->setUsername( $username );
	}

	/**
	 * Set the username used to authenticate the user.

	 * @param $username string
	 * @return $this
	 * @throws Exception\ClientException
	 */
	public function setUsername( $username ) {

		if ( empty( $username ) ) {
			throw new ClientException( "Username can not be empty" );
		}

        $this->token = null;
		$this->username = $username;
		return $this;
	}

	/**
	 * Set password encoded with md5 algorithm.
	 *
	 * @param $password
	 * @return $this
	 * @throws Exception\ClientException
	 */
	public function setPasswordHash( $password ) {

		if ( empty( $password ) ) {
			throw new ClientException( "Password can not be empty" );
		}

        $this->token = null;
		$this->password = $password;
		return $this;
	}

	/**
	 * Set password in plain text.
	 *
	 * @param $password
	 * @return $this
	 * @throws Exception\ClientException
	 */
	public function setPasswordRaw( $password ) {
		$this->setPasswordHash( md5( $password ) );
		return $this;
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
	 * Returns password
	 *
	 * @return string The salt password
	 */
	public function getPassword() {
		return $this->password;
	}

    public function getToken()
    {
        return $this->token;
    }

    public function setToken($token)
    {
        $this->username = null;
        $this->password = null;
        $this->token = $token;

        return $this;
    }
}
