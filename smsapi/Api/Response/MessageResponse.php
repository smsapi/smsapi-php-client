<?php

namespace SMSApi\Api\Response;

/**
 * Class MessageResponse
 * @package SMSApi\Api\AbstractContactsResponse
 */
class MessageResponse implements Response {


	/**
	 * @var int
	 */
	private $id = null;
	/**
	 * @var int
	 */
	private $number = null;
	/**
	 * @var double
	 */
	private $points = null;
	/**
	 * @var string
	 */
	private $status = null;

	/**
	 * @var null
	 */
	private $error = null;

	/**
	 * @var string
	 */
	private $idx = null;

	/**
	 * @param $id
	 * @param $points
	 * @param $number
	 * @param $status
	 * @param $error
	 * @param $idx
	 */
	function __construct( $id, $points, $number, $status, $error, $idx ) {
		$this->id = $id;
		$this->points = $points;
		$this->number = $number;
		$this->status = $status;
		$this->error = $error;
		$this->idx = $idx;
	}

	/**
	 * Returns system message ID number
	 *
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Returns phone number
	 *
	 * @return int Phone number
	 */
	public function getNumber() {
		return $this->number;
	}

	/**
	 * Returns costs of delivery
	 *
	 * @return double
	 */
	public function getPoints() {
		return $this->points;
	}

	/**
	 * Returns message status
	 *
	 * Example:
	 * DRAFT DELIVERED SENT UNDELIVERED EXPIRED QUEUE UNKNOWN UNDELIVERED FAILED PENDING ACCEPTED RENEWAL STOP
	 *
	 * @return string
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * @return null
	 */
	public function getError() {
		return $this->error;
	}

	/**
	 * Returns private idx number
	 *
	 * @return string
	 */
	public function getIdx() {
		return $this->idx;
	}

}
