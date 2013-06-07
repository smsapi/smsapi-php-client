<?php

namespace SMSApi\Api\Action\Phonebook;

use SMSApi\Api\Action\AbstractAction;
use SMSApi\Proxy\Uri;

class GroupGet extends AbstractAction {

	protected function response( $data ) {

		return new \SMSApi\Api\Response\GroupResponse( $data );
	}

	public function uri() {

		$query = "";

		$query .= $this->paramsLoginToQuery();

		$query .= $this->paramsOther();

		return new Uri( $this->proxy->getProtocol(), $this->proxy->getHost(), $this->proxy->getPort(), "/api/phonebook.do", $query );
	}

	public function setGroup( $groupName ) {
		$this->params[ "get_group" ] = $groupName;
		return $this;
	}

}