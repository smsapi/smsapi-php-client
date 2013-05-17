<?php

namespace SMSApi\Api\Response;

class MessageStatus {

	/**
	 * @param \stdClass $obj
	 * @return MessageStatus
	 */
	public static function fromObject(\stdClass $obj) {

		$n = new MessageStatus();

		$n->id = isset($obj->id) ? (string)$obj->id : null;
		$n->number = isset($obj->number) ? (string)$obj->number : null;
		$n->points = isset($obj->points) ? (float)$obj->id : null;
		$n->status = isset($obj->status) ? (string)$obj->status : null;
		$n->error = isset($obj->error) ? (string)$obj->error : null;
		$n->idx = isset($obj->idx) ? (string)$obj->idx : null;

		return $n;
	}

	private $id = null;
	private $number = null;
	private $points = null;
	private $status = null;
	private $error = null;
	private $idx = null;

	public function getID() {
		return $this->id;
	}

	public function getNumber() {
		return $this->number;
	}

	public function getPoints() {
		return $this->points;
	}

	public function getStatus() {
		return $this->status;
	}

	public function getError() {
		return $this->error;
	}

	public function getIDx() {
		return $this->idx;
	}
}
