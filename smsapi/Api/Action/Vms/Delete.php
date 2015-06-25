<?php

namespace SMSApi\Api\Action\Vms;

use SMSApi\Api\Action\AbstractAction;
use SMSApi\Api\Response\CountableResponse;
use SMSApi\Exception\ActionException;
use SMSApi\Proxy\Uri;

/**
 * Class Delete
 * @package SMSApi\Api\Action\Vms
 *
 * @method CountableResponse execute()
 */
class Delete extends AbstractAction
{
	/**
	 * @var \ArrayObject
	 */
	private $id;

	/**
	 *
	 */
	function __construct() {
		$this->id = new \ArrayObject();
	}

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

		$query .= "&sch_del=" . implode(",", $this->id->getArrayCopy());

		return new Uri( $this->proxy->getProtocol(), $this->proxy->getHost(), $this->proxy->getPort(), "/api/vms.do", $query );
	}

	/**
	 * Set ID of messages to delete.
	 *
	 * This id was returned after sending message.
	 *
	 * @param $id
	 * @return $this
	 * @throws ActionException
	 */
	public function filterById( $id ) {
		if ( !is_string( $id ) ) {
			throw new ActionException( 'Invalid value id' );
		}

		$this->id->append( $id );
		return $this;
	}

	/**
	 *
	 * Set array IDs of messages to delete.
	 *
	 * This id was returned after sending message.
	 *
	 * @param $ids
	 * @return $this
	 * @throws \SMSApi\Exception\ActionException
	 */
	public function filterByIds( array $ids ) {

		$this->id->exchangeArray( $ids );
		return $this;
	}

    /**
     * @deprecated since v1.0.0
     * @param $array
     * @return Delete
     */
	public function ids($array) {
		return $this->filterByIds($array);
	}

    /**
     * @deprecated since v1.0.0
     * @param $id
     * @return Delete
     * @throws ActionException
     */
	public function id($id) {
		return $this->filterById($id);
	}

}

