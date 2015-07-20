<?php

namespace SMSApi\Api\Response;

/**
 * Class UsersResponse
 * @package SMSApi\Api\AbstractContactsResponse
 */
class UsersResponse extends AbstractResponse {

	/**
	 * @var \ArrayObject|UserResponse[]
	 */
	private $list;

	/**
	 * @param $data
	 */
	function __construct( $data ) {
		parent::__construct( $data );

		$this->list = new \ArrayObject();

		if ( isset( $this->obj ) ) {
			foreach ( $this->obj as $res ) {
				$this->list->append( new UserResponse( $res ) );
			}
		}
	}

	/**
	 * @return \ArrayObject|UserResponse[]
	 */
	public function getList() {
		return $this->list;
	}

}
