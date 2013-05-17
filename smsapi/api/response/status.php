<?php

namespace SMSApi\Api\Response;

class Status {

	/**
	 * @param \stdClass $obj
	 * @return Status
	 */
	public static function fromObject(\stdClass $obj) {

		$n = new Status();

		$n->count = isset($obj->count) ? (int)$obj->count : 0;

		if( isset($obj->list) AND is_array($obj->list) ) {

			foreach( $obj->list as $e ) {
				$n->list[] = MessageStatus::fromObject($e);
			}
		}

		return $n;
	}

	private $count;

	/**
	 * @return int
	 */
	public function getCount() {
		return $this->count;
	}

	/**
	 * @var MessageStatus[]
	 */
	private $list = array();

	/**
	 * @return MessageStatus[]
	 */
	public function getList() {
		return $this->list;
	}
}
