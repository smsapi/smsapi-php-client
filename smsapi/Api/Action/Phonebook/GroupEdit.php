<?php

namespace SMSApi\Api\Action\Phonebook;

/**
 * Class GroupEdit
 * @package SMSApi\Api\Action\Phonebook
 * @deprecated use \SMSApi\Api\Action\Contacts\GroupEdit
 */
class GroupEdit extends GroupAdd {

	/**
	 * @deprecated since 1.0.0
	 * @param string $groupName group name
	 * @return $this
	 */
	public function setGroup( $groupName ) {
		$this->params[ "edit_group" ] = $groupName;
		return $this;
	}

	/**
	 * Set edited group.
	 *
	 * @param string $groupName group name
	 * @return $this
	 */
	public function filterByGroupName( $groupName ) {
		$this->params[ "edit_group" ] = $groupName;
		return $this;
	}

	/**
	 * Set new group name.
	 *
	 * @param string $groupName new group name
	 * @return $this
	 */
	public function setName( $groupName ) {
		$this->params[ "name" ] = $groupName;
		return $this;
	}

}
