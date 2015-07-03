<?php

namespace SMSApi\Api\Action\Sender;

use SMSApi\Api\Action\AbstractAction;
use SMSApi\Api\Response\CountableResponse;
use SMSApi\Proxy\Uri;

/**
 * Class Add
 * @package SMSApi\Api\Action\Sender
 */
class Add extends AbstractAction {

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
	 * Set new sender name.
	 *
	 * @param string $senderName sender name
	 * @return $this
	 */
	public function setName( $senderName ) {
		$this->params[ "add" ] = $senderName;
		return $this;
	}

}

