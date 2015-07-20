<?php

namespace SMSApi\Api\Action\Phonebook;

use SMSApi\Api\Action\AbstractAction;
use SMSApi\Proxy\Uri;

/**
 * Class GroupDelete
 * @package SMSApi\Api\Action\Phonebook
 * @deprecated use \SMSApi\Api\Action\Contacts\GroupDelete
 */
class GroupDelete extends AbstractAction {

	/**
	 * @param $data
	 * @return \SMSApi\Api\Response\RawResponse
	 */
	protected function response( $data ) {

		return new \SMSApi\Api\Response\RawResponse( $data );
	}

	/**
	 * @return Uri
	 */
	public function uri() {

		$query = "";

		$query .= $this->paramsLoginToQuery();

		$query .= $this->paramsOther();

		return new Uri( $this->proxy->getProtocol(), $this->proxy->getHost(), $this->proxy->getPort(), "/api/phonebook.do", $query );
	}

	/**
	 * @deprecated since v1.0.0
	 * @param string $groupName group name
	 * @return $this
	 */
	public function setGroup( $groupName ) {
		$this->params[ "delete_group" ] = $groupName;
		return $this;
	}

	/**
	 * Set group to delete.
	 *
	 * @param string $groupName group name
	 * @return $this
	 */
	public function filterByGroupName( $groupName ) {
		$this->params[ "delete_group" ] = $groupName;
		return $this;
	}

	/**
	 * Set true to remove contacts from phonebook.
	 * If contacts are in other groups, they will be only unbind.
	 *
	 * If this flag is false or unset contact will be only unbind from group.
	 *
	 * @param bool $remove if true contact in group will be removed
	 * @return $this
	 */
	public function removeContacts( $remove ) {
		if ( $remove == true ) {
			$this->params[ "remove_contacts" ] = "1";
		} else if ( $remove == false && isset( $this->params[ "remove_contacts" ] ) ) {
			unset( $this->params[ "remove_contacts" ] );
		}

		return $this;
	}

}
