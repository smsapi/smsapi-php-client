<?php

namespace SMSApi\Api\Action\Phonebook;

use SMSApi\Api\Action\AbstractAction;
use SMSApi\Proxy\Uri;

/**
 * Class ContactAdd
 * @package SMSApi\Api\Action\Phonebook
 */
class ContactAdd extends AbstractAction {

	/**
	 * @var \ArrayObject
	 */
	private $groups;

	/**
	 *
	 */
	function __construct() {
		$this->groups = new \ArrayObject();
	}

	/**
	 * @param $data
	 * @return \SMSApi\Api\Response\ContactResponse
	 */
	protected function response( $data ) {

		return new \SMSApi\Api\Response\ContactResponse( $data );
	}

	/**
	 * @return Uri
	 */
	public function uri() {

		$query = "";

		$query .= $this->paramsLoginToQuery();

		$query .= $this->paramsOther();

		if ( !empty( $this->groups ) ) {
			$query .= "&groups=" . implode( "|", $this->groups->getArrayCopy() );
		}

		return new Uri( $this->proxy->getProtocol(), $this->proxy->getHost(), $this->proxy->getPort(), "/api/phonebook.do", $query );
	}

	/**
	 * @param $number
	 * @return $this
	 */
	public function setNumber( $number ) {
		$this->params[ "add_contact" ] = $number;
		return $this;
	}

	/**
	 * @param $firstName
	 * @return $this
	 */
	public function setFirstName( $firstName ) {
		$this->params[ "first_name" ] = $firstName;
		return $this;
	}

	/**
	 * @param $lastName
	 * @return $this
	 */
	public function setLastName( $lastName ) {
		$this->params[ "last_name" ] = $lastName;
		return $this;
	}

	/**
	 * @param $info
	 * @return $this
	 */
	public function setInfo( $info ) {
		$this->params[ "info" ] = $info;
		return $this;
	}

	/**
	 * @param $email
	 * @return $this
	 */
	public function setEmail( $email ) {
		$this->params[ "email" ] = $email;
		return $this;
	}

	/**
	 * @param $birthday
	 * @return $this
	 */
	public function setBirthday( $birthday ) {
		$this->params[ "birthday" ] = $birthday;
		return $this;
	}

	/**
	 * @param $city
	 * @return $this
	 */
	public function setCity( $city ) {
		$this->params[ "city" ] = $city;
		return $this;
	}

	/**
	 * @param $gender
	 * @return $this
	 */
	public function setGender( $gender ) {
		$this->params[ "gender" ] = $gender;
		return $this;
	}

	/**
	 * @param $group
	 * @return $this
	 */
	public function setGroup( $group ) {
		$this->groups->append( $group );
		return $this;
	}

	/**
	 * @param array $groups
	 * @return $this
	 */
	public function setGroups( array $groups ) {
		$this->groups->exchangeArray( $groups );
		return $this;
	}

}

