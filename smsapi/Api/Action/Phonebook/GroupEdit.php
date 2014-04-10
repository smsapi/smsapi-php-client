<?php

namespace SMSApi\Api\Action\Phonebook;

/**
 * Class GroupEdit
 * @package SMSApi\Api\Action\Phonebook
 */
class GroupEdit extends GroupAdd {

	/**
	 * @param $groupName
	 * @return $this
	 */
	public function setGroup( $groupName ) {
		$this->params[ "edit_group" ] = $groupName;
		return $this;
	}

	/**
	 * @param $groupName
	 * @return $this
	 */
	public function setName( $groupName ) {
		$this->params[ "name" ] = $groupName;
		return $this;
	}

}
