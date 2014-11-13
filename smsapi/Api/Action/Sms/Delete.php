<?php

namespace SMSApi\Api\Action\Sms;

use SMSApi\Api\Action\AbstractAction;
use SMSApi\Api\Response\CountableResponse;
use SMSApi\Proxy\Uri;

/**
 * Class Delete
 * @package SMSApi\Api\Action\Sms
 *
 * @method CountableResponse execute()
 */
class Delete extends AbstractAction
{
	/**
	 * @var int
	 */
	private $id;

	/**
	 * @param $data
	 * @return CountableResponse
	 */
	protected function response($data)
    {
		return new CountableResponse($data);
	}

	/**
	 * @return Uri
	 */
	public function uri() {

		$query = "";

		$query .= $this->paramsLoginToQuery();

		$query .= $this->paramsOther();

		$query .= "&sch_del=" . $this->id;

		return new Uri( $this->proxy->getProtocol(), $this->proxy->getHost(), $this->proxy->getPort(), "/api/sms.do", $query );
	}


	/**
	 * Set ID of message to delete.
	 *
	 * This id was returned after sending message.
	 *
	 * @param $id
	 * @return $this
	 * @throws \SMSApi\Exception\ActionException
	 */
	public function filterById( $id ) {
		$this->id = $id;
		return $this;
	}

	/**
	 * @deprecated since v1.0.0
	 *
	 * @param $id
	 * @return $this
	 */
	public function id( $id ) {
		return $this->filterById($id);
	}

}

