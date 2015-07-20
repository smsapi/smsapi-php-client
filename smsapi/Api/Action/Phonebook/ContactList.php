<?php

namespace SMSApi\Api\Action\Phonebook;

use SMSApi\Api\Action\AbstractAction;
use SMSApi\Proxy\Uri;

/**
 * Class ContactList
 * @package SMSApi\Api\Action\Phonebook
 * @deprecated use \SMSApi\Api\Action\Contacts\ContactList
 */
class ContactList extends AbstractAction {

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
	 * @return \SMSApi\Api\Response\ContactsResponse
	 */
	protected function response( $data ) {

		return new \SMSApi\Api\Response\ContactsResponse( $data );
	}

	/**
	 * @return Uri
	 */
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

	/**
	 * @deprecated since v1.1.0
	 * @param $number
	 * @return $this
	 */
	public function setNumber( $number ) {
		$this->params[ "number" ] = $number;
		return $this;
	}

	/**
	 * Set filter contacts by phone number.
	 *
	 * @param string|number $number phone number
	 * @return $this
	 */
	public function filterByPhoneNumber( $number ) {
		$this->params[ "number" ] = $number;
		return $this;
	}

	/**
	 * @deprecated since v1.1.0
	 * @param $group
	 * @return $this
	 */
	public function setGroup( $group ) {
		$this->groups->append( $group );
		return $this;
	}


	/**
	 * Set filter contacts by group name.
	 *
	 * @param string $group group name
	 * @return $this
	 */
	public function filterByGroup( $group ) {
		$this->groups->append( $group );
		return $this;
	}

	/**
	 * Set filter contacts by group names.
	 *
	 * @param string[] $group array of group names
	 * @return $this
	 */
	public function filterByGroups( array $groups ) {
		$this->groups->exchangeArray( $groups );
		return $this;
	}

	/**
	 * @deprecated since v1.0.0
	 * @param array $groups
	 * @return $this
	 */
	public function setGroups( array $groups ) {
		$this->groups->exchangeArray( $groups );
		return $this;
	}

	/**
	 * @deprecated since v1.0.0
	 * @param $text
	 * @return $this
	 */
	public function setText( $text ) {
		$this->params[ "text_search" ] = $text;
		return $this;
	}


	/**
	 * The result list will contain contacts with given chars string.
	 *
	 * @param string $text search string
	 * @return $this
	 */
	public function search( $text ) {
		$this->params[ "text_search" ] = $text;
		return $this;
	}

	/**
	 * @deprecated since v1.1.0
	 * @param $gender
	 * @return $this
	 */
	public function setGender( $gender ) {
		$this->params[ "gender" ] = $gender;
		return $this;
	}

	/**
	 * Set filter by gender.
	 *
	 * @param string $gender The value of $gender can be: male, female, unknown
	 * @return $this
	 */
	public function filterByGender( $gender ) {
		$this->params[ "gender" ] = $gender;
		return $this;
	}

	/**
	 * Set order parameter.
	 *
	 * @param string $orderBy The value of $orderBy can be: first_name, last_name
	 * @return $this
	 */
	public function setOrderBy( $orderBy ) {
		$this->params[ "order_by" ] = $orderBy;

		return $this;
	}

	/**
	 * Set order direction.
	 *
	 * @param string $orderDir The value of $orderBy can be: desc, asc
	 * @return $this
	 */
	public function setOrderDir( $orderDir ) {
		$this->params[ "order_dir" ] = $orderDir;
		return $this;
	}

	/**
	 * Set result limit.
	 *
	 * @param int $limit Max limit is 200 contacts
	 * @return $this
	 */
	public function setLimit( $limit ) {
		$this->params[ "limit" ] = $limit;
		return $this;
	}

	/**
	 * Set result offset.
	 *
	 * @param int $offset
	 * @return $this
	 */
	public function setOffset( $offset ) {
		$this->params[ "offset" ] = $offset;
		return $this;
	}

}
