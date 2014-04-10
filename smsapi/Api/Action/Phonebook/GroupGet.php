<?php

namespace SMSApi\Api\Action\Phonebook;

use SMSApi\Api\Action\AbstractAction;
use SMSApi\Proxy\Uri;

/**
 * Class GroupGet
 * @package SMSApi\Api\Action\Phonebook
 */
class GroupGet extends AbstractAction {

	/**
	 * @param $data
	 * @return \SMSApi\Api\Response\GroupResponse
	 */
	protected function response( $data ) {

		return new \SMSApi\Api\Response\GroupResponse( $data );
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
		$this->params[ "get_group" ] = $groupName;
		return $this;
	}

}