<?php

namespace SMSApi\Api\Action\Phonebook;

use SMSApi\Api\Action\AbstractAction;
use SMSApi\Proxy\Uri;

class ContactAdd extends AbstractAction {

	private $groups;

	function __construct() {
		$this->groups = new \ArrayObject();
	}

	protected function response( $data ) {

		return new \SMSApi\Api\Response\ContactResponse( $data );
	}

	public function uri() {

		$query = "";

		$query .= $this->paramsLoginToQuery();

		$query .= $this->paramsOther();

		if ( !empty( $this->groups ) ) {
			$query .= "&groups=" . implode( "|", $this->groups->getArrayCopy() );
		}

		return new Uri( $this->proxy->getProtocol(), $this->proxy->getHost(), $this->proxy->getPort(), "/api/phonebook.do", $query );
	}

	public function setNumber( $number ) {
		$this->params[ "add_contact" ] = $number;
		return $this;
	}

	public function setFirstName( $firstName ) {
		$this->params[ "first_name" ] = $firstName;
		return $this;
	}

	public function setLastName( $lastName ) {
		$this->params[ "last_name" ] = $lastName;
		return $this;
	}

	public function setInfo( $info ) {
		$this->params[ "info" ] = $info;
		return $this;
	}

	public function setEmail( $email ) {
		$this->params[ "email" ] = $email;
		return $this;
	}

	public function setBirthday( $birthday ) {
		$this->params[ "birthday" ] = $birthday;
		return $this;
	}

	public function setCity( $city ) {
		$this->params[ "city" ] = $city;
		return $this;
	}

	public function setGender( $gender ) {
		$this->params[ "gender" ] = $gender;
		return $this;
	}

	public function setGroup( $group ) {
		$this->groups->append( $group );
		return $this;
	}

	public function setGroups( array $groups ) {
		$this->groups->exchangeArray( $groups );
		return $this;
	}

}

