<?php

namespace SMSApi\Api\Action;

abstract class AbstractAction {

	protected $client;
	protected $proxy;
	protected $params = array( );
	protected $to;
	protected $idx;
	protected $group;
	protected $date;

	function __construct() {
		$this->to = new \ArrayObject();
		$this->idx = new \ArrayObject();
	}

	abstract public function uri();

	abstract protected function response( $data );

	public function file() {
		return null;
	}

	public function client( \SMSApi\Client $client ) {
		$this->client = $client;
	}

	public function proxy( \SMSApi\Proxy\Proxy $proxy ) {
		$this->proxy = $proxy;
	}

	public function setTest( $val ) {
		if ( $val == true ) {
			$this->params[ 'test' ] = 1;
		} else if ( $val == false ) {
			unset( $this->params[ 'test' ] );
		}

		return $this;
	}

	protected function setJson( $val ) {
		if ( $val == true ) {
			$this->params[ 'format' ] = 'json';
		} else if ( $val == false ) {
			unset( $this->params[ 'format' ] );
		}

		return $this;
	}

	protected function paramsOther( $skip = "" ) {

		$query = "";

		foreach ( $this->params as $key => $val ) {
			if ( $key != $skip && $val != null ) {
				$query .= '&' . $key . '=' . $val;
			}
		}

		return $query;
	}

	protected function renderTo() {

		$sizeTo = $this->to->count();
		$sizeIdx = $this->idx->count();

		if ( $sizeIdx > 0 ) {
			if ( ($sizeTo != $sizeIdx ) ) {
				throw new \SMSApi\Exception\ActionException( "size idx is not equals to" );
			} else {
				return $this->renderList( $this->to, ',' ) + "&idx=" + $this->renderList( $this->idx, '|' );
			}
		}

		return $this->renderList( $this->to, ',' );
	}

	private function renderList( \ArrayObject $values, $delimiter ) {

		$query = "";
		$loop = 1;
		$size = $values->count();

		foreach ( $values as $val ) {
			$query .= $val;
			if ( $loop < $size ) {
				$query .= $delimiter;
			}

			$loop++;
		}

		return $query;
	}

	protected function paramsBasicToQuery() {

		$query = "";

		$query .= ($this->group != null) ? "&group=" . $this->group : "&to=" . $this->renderTo();

		$query .= ($this->date != null) ? "&date=" . $this->date : "";

		return $query;
	}

	protected function paramsLoginToQuery() {
		return "username=" . $this->client->getUsername() . "&password=" . $this->client->getPassword();
	}

	public function execute() {

		$data = null;
		$response = null;
		$name = null;

		try {

			$this->setJson( true );

			$data = $this->proxy->execute( $this );

			$this->handleError( $data );

			$response = $this->response( $data );

			return $response;
		} catch ( Exception $ex ) {
			throw new \SMSApi\Exception\ActionException( $ex . getMessage() );
		}
	}

	protected function handleError( $data ) {

		$error = new \SMSApi\Api\Response\ErrorResponse( $data );

		if ( $error->isError() ) {
			if ( \SMSApi\Exception\SmsapiException::isHostError( $error->code ) ) {
				throw new \SMSApi\Exception\HostException( $error->message, $error->code );
			}

			if ( \SMSApi\Exception\SmsapiException::isClientError( $error->code ) ) {
				throw new \SMSApi\Exception\ClientException( $error->message, $error->code );
			} else {
				throw new \SMSApi\Exception\ActionException( $error->message, $error->code );
			}
		}
	}

}