<?php

namespace SMSApi\Api\Action\Phonebook;

use SMSApi\Api\Action\AbstractAction;
use SMSApi\Proxy\Uri;

class GroupDelete extends AbstractAction {

	protected function response( $data ) {

		return new \SMSApi\Api\Response\RawResponse( $data );
	}

	public function uri() {

		$query = "";

		$query .= $this->paramsLoginToQuery();

		$query .= $this->paramsOther();

		return new Uri( $this->proxy->getProtocol(), $this->proxy->getHost(), $this->proxy->getPort(), "/api/phonebook.do", $query );
	}

	public function setGroup( $groupName ) {
		$this->params[ "delete_group" ] = $groupName;
		return $this;
	}

	public function removeContacts( $remove ) {
		if ( $remove == true ) {
			$this->params[ "remove_contacts" ] = "1";
		} else if ( $remove == false && isset( $this->params[ "remove_contacts" ] ) ) {
			unset( $this->params[ "remove_contacts" ] );
		}

		return $this;
	}

}

