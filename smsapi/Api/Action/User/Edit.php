<?php

namespace SMSApi\Api\Action\User;

/**
 * Class Edit
 * @package SMSApi\Api\Action\User
 */
class Edit extends Add {

	/**
	 * @param $username
	 * @return $this
	 */
	public function setUsername( $username ) {
		$this->params[ "set_user" ] = $username;
		return $this;
	}

}

