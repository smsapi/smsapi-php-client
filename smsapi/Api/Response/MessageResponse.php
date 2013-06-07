<?php

namespace SMSApi\Api\Response;

class MessageResponse implements Response {

	private $id = null;
	private $number = null;
	private $points = null;
	private $status = null;
	private $error = null;
	private $idx = null;

	function __construct( $id, $points, $number, $status, $error, $idx ) {
		$this->id = $id;
		$this->points = $points;
		$this->number = $number;
		$this->status = $status;
		$this->error = $error;
		$this->idx = $idx;
	}

	public function getId() {
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

	public function getIdx() {
		return $this->idx;
	}

}
