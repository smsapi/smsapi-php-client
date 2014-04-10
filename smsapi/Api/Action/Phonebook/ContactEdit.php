<?php

namespace SMSApi\Api\Action\Phonebook;

/**
 * Class ContactEdit
 * @package SMSApi\Api\Action\Phonebook
 */
class ContactEdit extends ContactAdd {

	/**
	 * @param $number
	 * @return $this
	 */
	public function setContact( $number ) {
		$this->params[ "edit_contact" ] = $number;
		return $this;
	}

	/**
	 * @param $number
	 * @return $this
	 */
	public function setNumber( $number ) {
		$this->params[ "new_number" ] = $number;
		return $this;
	}

}
