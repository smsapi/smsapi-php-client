<?php

namespace SMSApi\Api\Action\User;

class Edit extends Add {

	public function setUsername( $username ) {
		$this->params[ "set_user" ] = $username;
		return $this;
	}

}

