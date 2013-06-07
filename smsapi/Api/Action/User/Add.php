<?php

namespace SMSApi\Api\Action\User;

use SMSApi\Api\Action\AbstractAction;
use SMSApi\Proxy\Uri;

class Add extends AbstractAction {

	protected function response( $data ) {

		return new \SMSApi\Api\Response\UserResponse( $data );
	}

	public function uri() {

		$query = "";

		$query .= $this->paramsLoginToQuery();

		$query .= $this->paramsOther();

		return new Uri( $this->proxy->getProtocol(), $this->proxy->getHost(), $this->proxy->getPort(), "/api/user.do", $query );
	}

	public function setUsername( $username ) {
		$this->params[ "add_user" ] = $username;
		return $this;
	}

	public function setPassword( $password ) {
		$this->params[ "pass" ] = $password;
		return $this;
	}

	public function setPasswordApi( $password ) {
		$this->params[ "pass_api" ] = $password;
		return $this;
	}

	public function setLimit( $limit ) {
		$this->params[ "limit" ] = $limit;
		return $this;
	}

	public function setMonthLimit( $limit ) {
		$this->params[ "month_limit" ] = $limit;
		return $this;
	}

	public function setSenders( $access ) {

		if ( $access == true ) {
			$this->params[ "senders" ] = "1";
		} else if ( $access == false ) {
			$this->params[ "senders" ] = "0";
		}

		return $this;
	}

	public function setPhonebook( $access ) {

		if ( $access == true ) {
			$this->params[ "phonebook" ] = "1";
		} else if ( $access == false ) {
			$this->params[ "phonebook" ] = "0";
		}

		return $this;
	}

	public function setActive( $val ) {

		if ( $val == true ) {
			$this->params[ "active" ] = "1";
		} else if ( $val == false ) {
			$this->params[ "active" ] = "0";
		}

		return $this;
	}

	public function setInfo( $info ) {
		$this->params[ "info" ] = $info;
		return $this;
	}

}

