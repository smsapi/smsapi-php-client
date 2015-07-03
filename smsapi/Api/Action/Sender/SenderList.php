<?php

namespace SMSApi\Api\Action\Sender;

use SMSApi\Api\Action\AbstractAction;
use SMSApi\Api\Response\SendersResponse;
use SMSApi\Proxy\Uri;

/**
 * Class SenderList
 * @package SMSApi\Api\Action\Sender
 */
class SenderList extends AbstractAction {

	/**
	 * @param $data
	 * @return SendersResponse
	 */
	protected function response( $data ) {

		return new SendersResponse( $data );
	}

	/**
	 * @return Uri
	 */
	public function uri() {

		$query = "";

		$query .= $this->paramsLoginToQuery();

		$query .= $this->paramsOther();

		$query .= "&list=1";

		return new Uri( $this->proxy->getProtocol(), $this->proxy->getHost(), $this->proxy->getPort(), "/api/sender.do", $query );
	}

}

