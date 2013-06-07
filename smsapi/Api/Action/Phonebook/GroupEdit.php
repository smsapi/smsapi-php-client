<?php

namespace SMSApi\Api\Action\Phonebook;

class GroupEdit extends GroupAdd {

	public function setGroup( $groupName ) {
		$this->params[ "edit_group" ] = $groupName;
		return $this;
	}

	public function setName( $groupName ) {
		$this->params[ "name" ] = $groupName;
		return $this;
	}

}
