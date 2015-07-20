<?php

namespace SMSApi\Api\Action\Phonebook;

use SMSApi\Api\Action\AbstractAction;
use SMSApi\Proxy\Uri;

/**
 * Class GroupAdd
 * @package SMSApi\Api\Action\Phonebook
 * @deprecated use \SMSApi\Api\Action\Contacts\GroupAdd
 */
class GroupAdd extends AbstractAction {

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
	 * Set group name.
	 *
	 * @param string $groupName
	 * @return $this
	 */
	public function setName( $groupName ) {
		$this->params[ "add_group" ] = $groupName;
		return $this;
	}

	/**
	 * Set additional group description.
	 *
	 * @param string $info group description
	 * @return $this
	 */
	public function setInfo( $info ) {
		$this->params[ "info" ] = $info;
		return $this;
	}

}

