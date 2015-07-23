<?php

namespace SMSApi\Api\Action;

use Exception;
use SMSApi\Api\Response\ErrorResponse;
use SMSApi\Client;
use SMSApi\Exception\ActionException;
use SMSApi\Exception\ClientException;
use SMSApi\Exception\ContactsException;
use SMSApi\Exception\HostException;
use SMSApi\Exception\SmsapiException;
use SMSApi\Proxy\Proxy;

/**
 * Class AbstractAction
 * @package SMSApi\Api\Action
 */
abstract class AbstractAction
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_DELETE = 'DELETE';
    const METHOD_PUT = 'PUT';
    const METHOD_HEAD = 'HEAD';

    /**
	 * @var Client
	 */
	protected $client;

	/** @var Proxy */
	protected $proxy;

	/**
	 * @var array
	 */
	protected $params = array();
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
     * @param Client $client
     * @return $this
     */
	public function client( Client $client ) {
		$this->client = $client;

        return $this;
	}

    /**
     * @param Proxy $proxy
     * @return $this
     */
	public function proxy( Proxy $proxy ) {
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

    public function isContacts()
    {
        return $this->isContacts;
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
            if ($key != $skip && $val !== null) {
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
	 * @throws ActionException
	 */
	protected function renderTo() {

		$sizeTo = $this->to->count();
		$sizeIdx = $this->idx->count();

		if ( $sizeIdx > 0 ) {
			if ( ($sizeTo != $sizeIdx ) ) {
				throw new ActionException( "size idx is not equals to" );
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

            $data = $this->proxy->execute($this);

            $this->handleError($data, $this->isContacts);

            if ($this->getMethod() === self::METHOD_HEAD and $data['size']) {
                return $this->response(json_encode(array('size' => $data['size'])));
            } else {
                return $this->response($data['output']);
            }
		}
		catch ( Exception $ex )
		{
			throw new ActionException($ex->getMessage(), $ex->getCode(), $ex);
		}
	}

    public function getMethod()
    {
        return self::METHOD_POST;
    }

    /**
     * @param array $data
     * @param bool $isContacts
     * @throws ActionException
     * @throws ClientException
     * @throws ContactsException
     * @throws HostException
     */
	protected function handleError(array $data, $isContacts)
    {
        if ($isContacts) {
            if ($data['code'] < 200 or $data['code'] > 299) {
                throw new ContactsException($data);
            }
        } else {
            $error = new ErrorResponse($data['output']);

            if ($error->isError()) {
                if (SmsapiException::isHostError($error->code)) {
                    throw new HostException($error->message, $error->code);
                } elseif (SmsapiException::isClientError($error->code) ) {
                    throw new ClientException($error->message, $error->code);
                } else {
                    throw new ActionException($error->message, $error->code);
                }
            }
        }
	}
}
