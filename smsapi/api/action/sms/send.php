<?php

namespace SMSApi\Api\Action\SMS;

/**
 * Class Send
 * @method \SMSApi\Api\Response\Status execute() execute()
 */
class Send extends \SMSApi\Api\Action\Base {

	public function __construct() {
		parent::__construct();
	}

	protected function uri() { return 'sms.do'; }

	protected function values() {

		$values = array(
			'format' => 'json',
			'username' => $this->client->getUsername(),
			'password' => $this->client->getPassword(),
		);

		if( !empty($this->groups) AND empty($this->to) ) {
			$values['group'] = implode(',', $this->groups);
		}
		else if( !empty($this->to) AND empty($this->groups) ) {
			$values['to'] = implode(',', $this->to);
		}
		else {
			throw new \InvalidArgumentException();
		}

		if( $this->from ) $values['from'] = $this->from;

		if( $this->date_sent ) $values['date'] = $this->date_sent;
		if( $this->date_expire ) $values['expiration_date'] = $this->date_expire;

		$values['single'] = ($this->single ? '1' : '0');
		$values['nounicode'] = ($this->nounicode ? '1' : '0');
		$values['flash'] = ($this->flash ? '1' : '0');
		$values['fast'] = ($this->fast ? '1' : '0');

		$values['message'] = $this->text;
		$values['datacoding'] = $this->datacoding;
		$values['max_parts'] = $this->max_parts;
		$values['partner'] = $this->partner;
		$values['encoding'] = $this->encoding;
		$values['test'] = $this->test;

		if( $this->idx ) $values['idx'] = implode('|', $this->idx);
		$values['check_idx'] = $this->check_idx ? '1' : '0';

		return $values;
	}

	protected function makeResult(\stdClass $obj) {
		return \SMSApi\Api\Response\Status::fromObject($obj);
	}

	protected $from = null;

	/**
	 * @param $from string
	 * @return $this
	 */
	public function setFrom($from) {

		$this->from = $from;
		return $this;
	}

	protected $text;

	/**
	 * @param $text string
	 * @return $this
	 */
	public function setText($text) {
		$this->text = $text;
		return $this;
	}

	protected $to = null;

	public function setTo($to) {

		if( !is_array($to) ) {
			$to = array($to);
		}

		$this->to = $to;
		return $this;
	}

	protected $groups = null;

	/**
	 * @param $group string|string[]
	 * @return $this
	 */
	public function setGroup($group) {

		if( !is_array($group) ) {
			$group = array($group);
		}

		$this->groups = $group;
		return $this;
	}

	protected $date_sent = null;

	public function setDateSent($date) {
		$this->date_sent = $date;
		return $this;
	}

	protected $date_expire = null;

	public function setDateExpiret($date) {
		$this->date_expire = $date;
		return $this;
	}

	protected $single = false;

	public function setSingle($single) {
		$this->single = (bool)$single;
		return $this;
	}

	protected $nounicode = false;

	public function setNoUnicode($nounicode) {
		$this->nounicode = (bool)$nounicode;
		return $this;
	}

	protected $flash = false;

	public function setFlash($flash) {
		$this->flash = (bool)$flash;
		return $this;
	}

	protected $fast = false;

	public function setFast($fast) {
		$this->fast = (bool)$fast;
		return $this;
	}

	protected $datacoding = null;

	public function setDataCoding($datacoding) {
		$this->datacoding = $datacoding;
		return $this;
	}

	protected $max_parts = null;

	public function setMaxParts($max_parts) {
		$this->max_parts = (int)$max_parts;
		return $this;
	}

	protected $partner = null;

	public function setPartner($partner) {
		$this->partner = $partner;
		return $this;
	}

	protected $encoding = 'utf-8';

	public function setEncoding($encoding) {
		$this->encoding = $encoding;
		return $this;
	}

	protected $check_idx = false;
	public function setCheckIDx($flag) {

		$this->check_idx = (bool)$flag;
		return $this;
	}

	protected $idx = null;

	public function setIDx($idx) {

		if( !is_array($idx) ) {
			$idx = array($idx);
		}

		$this->idx = $idx;
		return $this;
	}

	protected $test = false;

	public function setTest($test) {
		$this->test = (bool)$test;
		return $this;
	}
}