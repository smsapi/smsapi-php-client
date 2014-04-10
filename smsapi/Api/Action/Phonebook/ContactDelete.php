<?php

namespace SMSApi\Api\Action\Phonebook;

use SMSApi\Api\Action\AbstractAction;
use SMSApi\Proxy\Uri;

/**
 * Class ContactDelete
 * @package SMSApi\Api\Action\Phonebook
 */
class ContactDelete extends AbstractAction {

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
	 * @param $number
	 * @return $this
	 */
	public function setContact( $number ) {
		$this->params[ "delete_contact" ] = $number;
		return $this;
	}

}

