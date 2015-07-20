<?php

namespace SMSApi\Api\Action\Phonebook;

/**
 * Class ContactEdit
 * @package SMSApi\Api\Action\Phonebook
 * @deprecated use \SMSApi\Api\Action\Contacts\ContactEdit
 */
class ContactEdit extends ContactAdd {


	/**
	 * @deprecated since v1.0.0
	 */
	public function setContact( $number ) {
		return $this->filterByPhoneNumber($number);
	}

	/**
	 * Select contact phone number to edit.
	 *
	 * @param string|int $number phone number
	 * @return $this
	 */
	public function filterByPhoneNumber( $number ) {
		$this->params[ "edit_contact" ] = $number;
		return $this;
	}

	/**
	 * Set new phone number.
	 *
	 * @param string|int $number phone number
	 * @return $this
	 */
	public function setNumber( $number ) {
		$this->params[ "new_number" ] = $number;
		return $this;
	}


	/**
	 * Add contact to group.
	 *
	 * @param $groupName
	 */
	public function addToGroup($groupName)
	{
		$this->params[ "add_to_group" ] = $groupName;
	}


	/**
	 * Remove contact from group.
	 *
	 * @param $groupName
	 */
	public function removeFromGroup($groupName)
	{
		$this->params[ "remove_from_groups" ] = $groupName;
	}

}
