<?php

namespace SMSApi\Api\Action\Phonebook;

use SMSApi\Api\Action\AbstractAction;
use SMSApi\Proxy\Uri;

/**
 * Class GroupList
 * @package SMSApi\Api\Action\Phonebook
 * @deprecated use \SMSApi\Api\Action\Contacts\GroupList
 */
class GroupList extends AbstractAction {

	/**
	 * @param $data
	 * @return \SMSApi\Api\Response\GroupsResponse
	 */
	protected function response( $data ) {

		return new \SMSApi\Api\Response\GroupsResponse( $data );
	}

	/**
	 * @return Uri
	 */
	public function uri() {

		$query = "";

		$query .= $this->paramsLoginToQuery();

		$query .= $this->paramsOther();

		$query .= "&list_groups=1";

		return new Uri( $this->proxy->getProtocol(), $this->proxy->getHost(), $this->proxy->getPort(), "/api/phonebook.do", $query );
	}

}

