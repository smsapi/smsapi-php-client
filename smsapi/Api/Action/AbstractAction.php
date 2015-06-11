<?php

namespace SMSApi\Api\Action;

use Exception;
use SMSApi\Api\Action\Contacts\ContactsAction;
use SMSApi\Exception\ActionException;
use SMSApi\Exception\ClientException;
use SMSApi\Exception\HostException;
use SMSApi\Exception\ProxyException;
use SMSApi\Exception\SmsapiException;
use SMSApi\Proxy\Proxy;

/**
 * Class AbstractAction
 * @package SMSApi\Api\Action
 */
abstract class AbstractAction
{
    /**
	 * @var
	 */
	protected $client;

	/** @var Proxy */
	protected $proxy;

	/**
	 * @var array
	 */
	protected $params = [ ];
	/**
	 * @var \ArrayObject
	 */
	protected $to;
	/**
	 * @var \ArrayObject
	 */
	protected $idx;
	/**
	 * @var
	 */
	protected $group;
	/**
	 * @var
	 */
	protected $date;
	/**
	 * @var
	 */
	protected $encoding;

    protected $isContacts = false;

	/**
	 *
	 */
	function __construct() {
		$this->to = new \ArrayObject();
		$this->idx = new \ArrayObject();
	}

	/**
	 * @return mixed
	 */
	abstract public function uri();

	/**
	 * @param $data
	 * @return mixed
	 */
	abstract protected function response( $data );

	/**
	 * @return null
	 */
	public function file() {
		return null;
	}

	/**
	 * @param \SMSApi\Client $client
	 */
	public function client( \SMSApi\Client $client ) {
		$this->client = $client;

        return $this;
	}

	/**
	 * @param \SMSApi\Proxy\Proxy $proxy
	 */
	public function proxy( \SMSApi\Proxy\Proxy $proxy ) {
		$this->proxy = $proxy;

        return $this;
	}

	/**
	 * @param $val
	 * @return $this
	 */
	public function setTest( $val ) {
		if ( $val == true ) {
			$this->params[ 'test' ] = 1;
		} else if ( $val == false ) {
			unset( $this->params[ 'test' ] );
		}

		return $this;
	}

	/**
	 * @param $val
	 * @return $this
	 */
	protected function setJson( $val ) {
		if ( $val == true ) {
			$this->params[ 'format' ] = 'json';
		} else if ( $val == false ) {
			unset( $this->params[ 'format' ] );
		}

		return $this;
	}

	protected function paramsOther($skip = '')
    {
        $query = '';
        foreach ($this->params as $key => $val) {
            if ($key != $skip && $val != null) {
                if (is_array($val)) {
                    foreach ($val as $v) {
                        $query .= '&' . $key . '[]=' . $v;
                    }
                } else {
                    $query .= '&' . $key . '=' . $val;
                }
            }
        }

        return $query;
	}

	/**
	 * @return string
	 * @throws \SMSApi\Exception\ActionException
	 */
	protected function renderTo() {

		$sizeTo = $this->to->count();
		$sizeIdx = $this->idx->count();

		if ( $sizeIdx > 0 ) {
			if ( ($sizeTo != $sizeIdx ) ) {
				throw new \SMSApi\Exception\ActionException( "size idx is not equals to" );
			} else {
				return $this->renderList( $this->to, ',' ) . "&idx=" . $this->renderList( $this->idx, '|' );
			}
		}

		return $this->renderList( $this->to, ',' );
	}

	/**
	 * @param \ArrayObject $values
	 * @param $delimiter
	 * @return string
	 */
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

	/**
	 * @return string
	 * @throws \SMSApi\Exception\ActionException
	 */
	protected function paramsBasicToQuery() {

		$query = "";

		$query .= ($this->group != null) ? "&group=" . $this->group : "&to=" . $this->renderTo();

		$query .= ($this->date != null) ? "&date=" . $this->date : "";

		$query .= ( $this->encoding != null ) ? "&encoding=" . $this->encoding : "";

		return $query;
	}

	/**
	 * @return string
	 */
	protected function paramsLoginToQuery() {
		return "username=" . $this->client->getUsername() . "&password=" . $this->client->getPassword();
	}

	/**
	 * @return mixed
	 * @throws \SMSApi\Exception\ClientException
	 * @throws \SMSApi\Exception\ActionException
	 * @throws \SMSApi\Exception\HostException
	 */
	public function execute()
	{
		try
		{
			$this->setJson( true );

			$data = $this->proxy->execute( $this );

            if ($this->isContacts) {
                $this->handleContactsError($data);

                return $this->response($data['output']);
            } else {
                $this->handleError($data);

                return $this->response($data);
            }
		}
		catch ( Exception $ex )
		{
			throw new \SMSApi\Exception\ActionException( $ex->getMessage() );
		}
	}

	/**
	 * @param $data
	 * @throws \SMSApi\Exception\ActionException
	 * @throws \SMSApi\Exception\ClientException
	 * @throws \SMSApi\Exception\HostException
	 */
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

    private function handleContactsError(array $data)
    {
        if ($data['code'] < 200 and $data['code'] > 299) {
            if (isset($data['output']['code'], $data['output']['message'])) {
                $code = $data['output']['code'];
                $message = $data['output']['message'];
                if (SmsapiException::isHostError($code)) {
                    throw new HostException($message, $code);
                } elseif (SmsapiException::isClientError($code) ) {
                    throw new ClientException($message, $code);
                } else {
                    throw new ActionException($message, $code);
                }
            } else {
                throw new ProxyException;
            }
        }
    }
}
