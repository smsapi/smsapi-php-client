<?php

namespace SMSApi\Api\Action\Sender;

use SMSApi\Api\Action\AbstractAction;
use SMSApi\Api\Response\CountableResponse;
use SMSApi\Proxy\Uri;

/**
 * Class Delete
 * @package SMSApi\Api\Action\Sender
 */
class Delete extends AbstractAction {

	/**
	 * @param $data
	 * @return CountableResponse
	 */
	protected function response( $data ) {

		return new CountableResponse( $data );
	}

	/**
	 * @return Uri
	 */
	public function uri() {

		$query = "";

		$query .= $this->paramsLoginToQuery();

		$query .= $this->paramsOther();

		return new Uri( $this->proxy->getProtocol(), $this->proxy->getHost(), $this->proxy->getPort(), "/api/sender.do", $query );
	}

	/**
	 * Set filter by sender name.
	 *
	 * @param $senderName string Sender name do delete
	 * @return $this
	 */
	public function filterBySenderName( $senderName ) {
		$this->params[ "delete" ] = $senderName;
		return $this;
	}

	/**
	 * @deprecated since v1.0.0
	 */
	public function setSender( $senderName ) {
		return $this->filterBySenderName($senderName);
	}

}

