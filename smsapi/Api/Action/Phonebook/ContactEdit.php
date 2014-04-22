<?php

namespace SMSApi\Api\Action\Phonebook;

/**
 * Class ContactEdit
 * @package SMSApi\Api\Action\Phonebook
 */
class ContactEdit extends ContactAdd {


	/**
	 * @deprecated since v1.0.0
	 */
	public function setContact( $number ) {
		return $this->phoneNumber($number);
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

}
