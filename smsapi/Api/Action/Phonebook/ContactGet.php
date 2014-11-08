<?php

namespace SMSApi\Api\Action\Phonebook;

use SMSApi\Api\Action\AbstractAction;
use SMSApi\Proxy\Uri;

/**
 * Class ContactGet
 * @package SMSApi\Api\Action\Phonebook
 */
class ContactGet extends AbstractAction
{
    /**
     * Add contact groups to response
     *
     * @var array
     */
    protected $params = array(
        "with_groups" => 1,
    );

	/**
	 * @param $data
	 * @return \SMSApi\Api\Response\ContactResponse
	 */
	protected function response( $data ) {

		return new \SMSApi\Api\Response\ContactResponse( $data );
	}

	/**
	 * @return Uri
	 */
	public function uri() {

		$query = "";

		$query .= $this->paramsLoginToQuery();

		$query .= $this->paramsOther();

		return new Uri( $this->proxy->getProtocol(), $this->proxy->getHost(), $this->proxy->getPort(), "/api/phonebook.do", $query );
	}

	/**
	 * @deprecated since v1.0.0
	 */
	public function setContact( $number ) {
		return $this->filterByPhoneNumber( $number );
	}

	/**
	 * Set filter by contact phone number.
	 *
	 * @param string|int $number phone number
	 * @return $this
	 */
	public function filterByPhoneNumber( $number ) {
		$this->params[ "get_contact" ] = $number;
		return $this;
	}
}
