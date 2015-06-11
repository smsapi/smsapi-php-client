<?php

namespace SMSApi\Api\Response;

/**
 * Class GroupsResponse
 * @package SMSApi\Api\AbstractContactsResponse
 * @deprecated use Contacts\GroupsResponse
 */
class GroupsResponse extends CountableResponse {

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
				$this->list->append( new GroupResponse( $res ) );
			}
		}
	}

	/**
	 * @return \ArrayObject}GroupResponse[]
	 */
	public function getList() {
		return $this->list;
	}

}
