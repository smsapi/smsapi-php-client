<?php
//sms
namespace SMSApi\Api\Action\Sms;

use SMSApi\Api\Action\AbstractAction;
use SMSApi\Proxy\Uri;

/**
 * @method \SMSApi\Api\Response\StatusResponse execute() 
 */
class Send extends AbstractAction {

	/**
	 * @var string
	 */
	protected $encoding = 'utf-8';

	/**
	 * @param $data
	 * @return \SMSApi\Api\Response\StatusResponse
	 */
	protected function response( $data ) {

		return new \SMSApi\Api\Response\StatusResponse( $data );
	}

	/**
	 * @return Uri
	 * @throws \SMSApi\Exception\ActionException
	 */
	public function uri() {

		$query = "";

		$query .= $this->paramsLoginToQuery();

		$query .= $this->paramsBasicToQuery();

		$query .= $this->paramsOther();

		return new Uri( $this->proxy->getProtocol(), $this->proxy->getHost(), $this->proxy->getPort(), "/api/sms.do", $query );
	}

	/**
	 * @param $text
	 * @return $this
	 */
	public function setText( $text ) {
		$this->params[ 'message' ] = urlencode( $text );
		return $this;
	}

	/**
	 * @param $encoding
	 * @return $this
	 */
	public function setEncoding( $encoding ) {
		$this->encoding = $encoding;
		return $this;
	}


	/**
	 * @param $to
	 * @return $this
	 */
	public function setTo( $to ) {

		if ( !is_array( $to ) ) {
			$to = array( $to );
		}

		$this->to->exchangeArray( $to );
		return $this;
	}

	/**
	 * @param $group
	 * @return $this
	 */
	public function setGroup( $group ) {
		$this->group = $group;
		return $this;
	}

	/**
	 * @param $date
	 * @return $this
	 */
	public function setDateSent( $date ) {
		$this->date = $date;
		return $this;
	}

	/**
	 * @param $idx
	 * @return $this
	 */
	public function setIDx( $idx ) {
		if ( !is_array( $idx ) ) {
			$idx = array( $idx );
		}

		$this->idx->exchangeArray( $idx );
		return $this;
	}

	/**
	 * @param $check
	 * @return $this
	 */
	public function setCheckIDx( $check ) {
		if ( $check == true ) {
			$this->params[ "check_idx" ] = "1";
		} else if ( $check == false ) {
			$this->params[ "check_idx" ] = "0";
		}

		return $this;
	}

	/**
	 * @param $partner
	 * @return $this
	 */
	public function setPartner( $partner ) {
		$this->params[ "partner_id" ] = $partner;
		return $this;
	}

	/**
	 * @param $date
	 * @return $this
	 */
	public function setDateExpire( $date ) {
		$this->params[ "expiration_date" ] = $date;
		return $this;
	}

	/**
	 * @param $sender
	 * @return $this
	 */
	public function setSender( $sender ) {
		$this->params[ "from" ] = $sender;
		return $this;
	}

	/**
	 * @param $single
	 * @return $this
	 */
	public function setSingle( $single ) {
		if ( $single == true ) {
			$this->params[ "single" ] = "1";
		} else if ( $single == false ) {
			$this->params[ "single" ] = "0";
		}

		return $this;
	}

	/**
	 * @param $noUnicode
	 * @return $this
	 */
	public function setNoUnicode( $noUnicode ) {
		if ( $noUnicode == true ) {
			$this->params[ "nounicode" ] = "1";
		} else if ( $noUnicode == false ) {
			$this->params[ "nounicode" ] = "0";
		}

		return $this;
	}

	/**
	 * @param $dataCoding
	 * @return $this
	 */
	public function setDataCoding( $dataCoding ) {
		$this->params[ "datacoding" ] = $dataCoding;
		return $this;
	}

	/**
	 * @param $flash
	 * @return $this
	 */
	public function setFlash( $flash ) {
		if ( $flash == true ) {
			$this->params[ "flash" ] = "1";
		} else if ( $flash == false && isset( $this->params[ "flash" ] ) ) {
			unset( $this->params[ "flash" ] );
		}

		return $this;
	}

	/**
	 * @param $normalize
	 * @return $this
	 */
	public function setNormalize( $normalize ) {

		if ( $normalize == true ) {
			$this->params[ "normalize" ] = "1";
		} else if ( $normalize == false && isset( $this->params[ "normalize" ] ) ) {
			unset( $this->params[ "normalize" ] );
		}

		return $this;
	}

	/**
	 * @param $fast
	 * @return $this
	 */
	public function setFast( $fast ) {
		if ( $fast == true ) {
			$this->params[ "fast" ] = "1";
		} else if ( $fast == false && isset( $this->params[ "fast" ] ) ) {
			unset( $this->params[ "fast" ] );
		}

		return $this;
	}

	/**
	 * @param int $i
	 * @param string|string[] $text
	 * @return $this
	 * @throws \OutOfRangeException
	 */
	public function SetParam($i, $text) {

		if ( $i > 3 || $i < 0 ) {
			throw new \OutOfRangeException;
		}

		$value = is_array($text) ? implode('?', $text) : $text;
		$this->params['param'.($i+1)] = urlencode( $value );

		return $this;
	}
}
