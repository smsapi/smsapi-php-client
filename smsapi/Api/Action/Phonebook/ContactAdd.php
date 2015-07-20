<?php

namespace SMSApi\Api\Action\Phonebook;

use SMSApi\Api\Action\AbstractAction;
use SMSApi\Proxy\Uri;

/**
 * Class ContactAdd
 * @package SMSApi\Api\Action\Phonebook
 * @deprecated use \SMSApi\Api\Action\Contacts\ContactAdd
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

		if ( count( $this->groups ) > 0 ) {
			$query .= "&groups=" . implode( ",", $this->groups->getArrayCopy() );
		}

		return new Uri( $this->proxy->getProtocol(), $this->proxy->getHost(), $this->proxy->getPort(), "/api/phonebook.do", $query );
	}

	/**
	 * Set contact phone number.
	 *
	 * @param string|int $number
	 * @return $this
	 */
	public function setNumber( $number ) {
		$this->params[ "add_contact" ] = $number;
		return $this;
	}

	/**
	 * Set contact first name.
	 *
	 * @param string $firstName
	 * @return $this
	 */
	public function setFirstName( $firstName ) {
		$this->params[ "first_name" ] = $firstName;
		return $this;
	}

	/**
	 * Set contact last name.
	 *
	 * @param string $lastName
	 * @return $this
	 */
	public function setLastName( $lastName ) {
		$this->params[ "last_name" ] = $lastName;
		return $this;
	}

	/**
	 * Set additional contact description.
	 *
	 * @param string $info
	 * @return $this
	 */
	public function setInfo( $info ) {
		$this->params[ "info" ] = $info;
		return $this;
	}

	/**
	 * Set contact email address.
	 *
	 * @param $email
	 * @return $this
	 */
	public function setEmail( $email ) {
		$this->params[ "email" ] = $email;
		return $this;
	}

	/**
	 * Set contact birthday date.
	 *
	 * @param string $birthday
	 * @return $this
	 */
	public function setBirthday( $birthday ) {
		$this->params[ "birthday" ] = $birthday;
		return $this;
	}

	/**
	 * Set contact city.
	 *
	 * @param string $city
	 * @return $this
	 */
	public function setCity( $city ) {
		$this->params[ "city" ] = $city;
		return $this;
	}

	/**
	 * Set contact gender.
	 *
	 * @param string $gender female, male, unknown
	 * @return $this
	 */
	public function setGender( $gender ) {
		$this->params[ "gender" ] = $gender;
		return $this;
	}

	/**
	 * Set contact to group.
	 * Others contact groups will be removed.
	 *
	 * @param string $group group name
	 * @return $this
	 */
	public function setGroup( $group ) {
		$this->groups->append( $group );
		return $this;
	}

	/**
	 * Set contact to groups.
	 * Others contact groups will be removed.
	 *
	 * @param array $groups array with groups names
	 * @return $this
	 */
	public function setGroups( array $groups ) {
		$this->groups->exchangeArray( $groups );
		return $this;
	}

}

