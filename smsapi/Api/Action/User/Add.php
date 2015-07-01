<?php

namespace SMSApi\Api\Action\User;

use SMSApi\Api\Action\AbstractAction;
use SMSApi\Api\Response\UserResponse;
use SMSApi\Proxy\Uri;

/**
 * Class Add
 * @package SMSApi\Api\Action\User
 */
class Add extends AbstractAction {

	/**
	 * @param $data
	 * @return UserResponse
	 */
	protected function response( $data ) {

		return new UserResponse( $data );
	}

	/**
	 * @return Uri
	 */
	public function uri() {

		$query = "";

		$query .= $this->paramsLoginToQuery();

		$query .= $this->paramsOther();

		return new Uri( $this->proxy->getProtocol(), $this->proxy->getHost(), $this->proxy->getPort(), "/api/user.do", $query );
	}

	/**
	 * New account user name.
	 *
	 * @param string $username account name
	 * @return $this
	 */
	public function setUsername( $username ) {
		$this->params[ "add_user" ] = $username;
		return $this;
	}

	/**
	 * Set account password encoded md5 algorithm.
	 *
	 * @param string $password  password encoded md5
	 * @return $this
	 */
	public function setPassword( $password ) {
		$this->params[ "pass" ] = $password;
		return $this;
	}

	/**
	 * Set account api password hashed with md5.
	 *
	 * @param string $password password api encoded md5
	 * @return $this
	 */
	public function setPasswordApi( $password ) {
		$this->params[ "pass_api" ] = $password;
		return $this;
	}

	/**
	 * Set credit limit granted to account.
	 *
	 * @param number $limit limit
	 * @return $this
	 */
	public function setLimit( $limit ) {
		$this->params[ "limit" ] = $limit;
		return $this;
	}

	/**
	 * Set month credits, the amount that will be granted 1st day of every month.
	 *
	 * @param number $limit limit number
	 * @return $this
	 */
	public function setMonthLimit( $limit ) {
		$this->params[ "month_limit" ] = $limit;
		return $this;
	}

	/**
	 * Set access to main account sender names.
	 *
	 * @param bool $access if true access is granted
	 * @return $this
	 */
	public function setFullAccessSenderNames( $access ) {
		if ( $access == true ) {
			$this->params[ "senders" ] = "1";
		} else if ( $access == false ) {
			$this->params[ "senders" ] = "0";
		}

		return $this;
	}

	/**
	 * @deprecated since v1.0.0 use SMSApi\Api\Action\User\Add::setFullAccessSenderNames
	 */
	public function setSenders( $access ) {
		return $this->setFullAccessSenderNames($access);
	}

	/**
	 * Set access to main account phonebook contacts.
	 *
	 * @param bool $access
	 * @return $this
	 */

	public function setFullAccessPhoneBook( $access ) {

		if ( $access == true ) {
			$this->params[ "phonebook" ] = "1";
		} else if ( $access == false ) {
			$this->params[ "phonebook" ] = "0";
		}

		return $this;
	}


	/**
	 * @deprecated since v1.0.0 use SMSApi\Api\Action\User\Add::setFullAccessPhoneBook
	 */
	public function setPhonebook( $access )
	{
		return $this->setFullAccessPhoneBook($access);
	}

	/**
	 * Set account active status.
	 *
	 * @param bool $val if true set account enable otherwise disabled
	 * @return $this
	 */
	public function setActive( $val ) {

		if ( $val == true ) {
			$this->params[ "active" ] = "1";
		} else if ( $val == false ) {
			$this->params[ "active" ] = "0";
		}

		return $this;
	}

	/**
	 * Set additional account description.
	 *
	 * @param string $info description
	 * @return $this
	 */
	public function setInfo( $info ) {
		$this->params[ "info" ] = $info;
		return $this;
	}

}

