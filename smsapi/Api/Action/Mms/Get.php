<?php

namespace SMSApi\Api\Action\Mms;

use SMSApi\Api\Action\AbstractAction;
use SMSApi\Proxy\Uri;

/**
 * Class Get
 * @package SMSApi\Api\Action\Mms
 */
class Get extends AbstractAction {

	/**
	 * @var \ArrayObject
	 */
	private $id;

	function __construct() {
		$this->id = new \ArrayObject();
	}

	/**
	 * @param $data
	 * @return \SMSApi\Api\Response\StatusResponse
	 */
	protected function response( $data ) {

		return new \SMSApi\Api\Response\StatusResponse( $data );
	}

	/**
	 * @return Uri
	 */
	public function uri() {

		$query = "";

		$query .= $this->paramsLoginToQuery();

		$query .= $this->paramsOther();

		$query .= "&status=" . implode( "|", $this->id->getArrayCopy() );

		return new Uri( $this->proxy->getProtocol(), $this->proxy->getHost(), $this->proxy->getPort(), "/api/mms.do", $query );
	}

	/**
	 * @param $id
	 * @return $this
	 * @throws \SMSApi\Exception\ActionException
	 */
	public function id( $id ) {
		if ( !is_string( $id ) ) {
			throw new \SMSApi\Exception\ActionException( 'Invalid value id' );
		}

		$this->id->append( $id );
		return $this;
	}

	/**
	 * @param $ids
	 * @return $this
	 * @throws \SMSApi\Exception\ActionException
	 */
	public function ids( $ids ) {
		if ( !is_array( $ids ) ) {
			throw new \SMSApi\Exception\ActionException( 'Invalid value ids' );
		}

		$this->id->exchangeArray( $ids );
		return $this;
	}

}

