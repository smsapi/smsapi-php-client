<?php

namespace SMSApi\Api\Action\Phonebook;

use SMSApi\Api\Action\AbstractAction;
use SMSApi\Proxy\Uri;

class ContactList extends AbstractAction {

	private $groups;

	function __construct() {
		$this->groups = new \ArrayObject();
	}

	protected function response( $data ) {

		return new \SMSApi\Api\Response\ContactsResponse( $data );
	}

	public function uri() {

		$query = "";

		$query .= $this->paramsLoginToQuery();

		$query .= $this->paramsOther();

		if ( !empty( $this->groups ) ) {
			$query .= "&groups=" . implode( ";", $this->groups->getArrayCopy() );
		}

		$query .= "&list_contacts=1";

		return new Uri( $this->proxy->getProtocol(), $this->proxy->getHost(), $this->proxy->getPort(), "/api/phonebook.do", $query );
	}

	public function setNumber( $number ) {
		$this->params[ "number" ] = $number;
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

	public function setText( $text ) {
		$this->params[ "text_search" ] = $text;
		return $this;
	}

	public function setGender( $gender ) {
		$this->params[ "gender" ] = $gender;
		return $this;
	}

	public function setOrderBy( $orderBy ) {
		$this->params[ "order_by" ] = $orderBy;
		return $this;
	}

	public function setOrderDir( $orderDir ) {
		$this->params[ "order_dir" ] = $orderDir;
		return $this;
	}

	public function setLimit( $limit ) {
		$this->params[ "limit" ] = $limit;
		return $this;
	}

	public function setOffset( $offset ) {
		$this->params[ "offset" ] = $offset;
		return $this;
	}

}

