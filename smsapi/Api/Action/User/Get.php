<?php

namespace SMSApi\Api\Action\User;

use SMSApi\Api\Action\AbstractAction;
use SMSApi\Proxy\Uri;

class Get extends AbstractAction {

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
		$this->params[ "get_user" ] = $username;
		return $this;
	}

}

