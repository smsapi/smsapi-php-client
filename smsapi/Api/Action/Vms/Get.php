<?php

namespace SMSApi\Api\Action\Vms;

use SMSApi\Api\Action\AbstractAction;
use SMSApi\Proxy\Uri;

class Get extends AbstractAction {

	private $id;

	function __construct() {
		$this->id = new \ArrayObject();
	}

	protected function response( $data ) {

		return new \SMSApi\Api\Response\StatusResponse( $data );
	}

	public function uri() {

		$query = "";

		$query .= $this->paramsLoginToQuery();

		$query .= $this->paramsOther();

		$query .= "&status=" . implode( "|", $this->id->getArrayCopy() );

		return new Uri( $this->proxy->getProtocol(), $this->proxy->getHost(), $this->proxy->getPort(), "/api/vms.do", $query );
	}

	public function id( $id ) {
		if ( !is_string( $id ) ) {
			throw new \SMSApi\Exception\ActionException( 'Invalid value id' );
		}

		$this->id->append( $id );
		return $this;
	}

	public function ids( $ids ) {
		if ( !is_array( $ids ) ) {
			throw new \SMSApi\Exception\ActionException( 'Invalid value ids' );
		}

		$this->id->exchangeArray( $ids );
		return $this;
	}

}
