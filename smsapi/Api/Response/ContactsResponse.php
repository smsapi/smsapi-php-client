<?php

namespace SMSApi\Api\Response;

/**
 * Class ContactsResponse
 * @package SMSApi\Api\AbstractContactsResponse
 * @deprecated use Contacts\ContactsResponse
 */
class ContactsResponse extends CountableResponse {

	/**
	 * @var \ArrayObject
	 */
	private $list;

	/**
	 * @param $data
	 */
	function __construct( $data ) {
		parent::__construct( $data );

		$this->list = new \ArrayObject();

		if ( isset( $this->obj->list ) ) {
			foreach ( $this->obj->list as $res ) {
				$this->list->append( new ContactResponse( $res ) );
			}
		}
	}

	/**
	 * @return \ArrayObject|ContactsResponse[]
	 */
	public function getList() {
		return $this->list;
	}

}
