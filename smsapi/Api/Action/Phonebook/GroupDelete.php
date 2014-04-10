<?php

namespace SMSApi\Api\Action\Phonebook;

use SMSApi\Api\Action\AbstractAction;
use SMSApi\Proxy\Uri;

/**
 * Class GroupDelete
 * @package SMSApi\Api\Action\Phonebook
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
	 * @param $groupName
	 * @return $this
	 */
	public function setGroup( $groupName ) {
		$this->params[ "delete_group" ] = $groupName;
		return $this;
	}

	/**
	 * @param $remove
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

