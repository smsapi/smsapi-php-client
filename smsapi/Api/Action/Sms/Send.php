<?php
//sms
namespace SMSApi\Api\Action\Sms;

use SMSApi\Api\Action\AbstractAction;
use SMSApi\Proxy\Uri;

/**
 * @method \SMSApi\Api\Response\StatusResponse execute() 
 */
class Send extends AbstractAction {

	protected function response( $data ) {

		return new \SMSApi\Api\Response\StatusResponse( $data );
	}

	public function uri() {

		$query = "";

		$query .= $this->paramsLoginToQuery();

		$query .= $this->paramsBasicToQuery();

		$query .= $this->paramsOther();

		return new Uri( $this->proxy->getProtocol(), $this->proxy->getHost(), $this->proxy->getPort(), "/api/sms.do", $query );
	}

	public function setText( $text ) {
		$this->params[ 'message' ] = $text;
		return $this;
	}

	public function setTo( $to ) {

		if ( !is_array( $to ) ) {
			$to = array( $to );
		}

		$this->to->exchangeArray( $to );
		return $this;
	}

	public function setGroup( $group ) {
		$this->group = $group;
		return $this;
	}

	public function setDateSent( $date ) {
		$this->date = $date;
		return $this;
	}

	public function setIDx( $idx ) {
		if ( !is_array( $idx ) ) {
			$idx = array( $idx );
		}

		$this->to->exchangeArray( $idx );
		return $this;
	}

	public function setCheckIDx( $check ) {
		if ( $check == true ) {
			$this->params[ "check_idx" ] = "1";
		} else if ( $check == false ) {
			$this->params[ "check_idx" ] = "0";
		}

		return $this;
	}

	public function setPartner( $partner ) {
		$this->params[ "partner_id" ] = $partner;
		return $this;
	}

	public function setDateExpire( $date ) {
		$this->params[ "expiration_date" ] = $date;
		return $this;
	}

	public function setSender( $sender ) {
		$this->params[ "from" ] = $sender;
		return $this;
	}

	public function setSingle( $single ) {
		if ( $single == true ) {
			$this->params[ "single" ] = "1";
		} else if ( $single == false ) {
			$this->params[ "single" ] = "0";
		}

		return $this;
	}

	public function setNoUnicode( $noUnicode ) {
		if ( $noUnicode == true ) {
			$this->params[ "nounicode" ] = "1";
		} else if ( $noUnicode == false ) {
			$this->params[ "nounicode" ] = "0";
		}

		return $this;
	}

	public function setDataCoding( $dataCoding ) {
		$this->params[ "datacoding" ] = $dataCoding;
		return $this;
	}

	public function setFlash( $flash ) {
		if ( $flash == true ) {
			$this->params[ "flash" ] = "1";
		} else if ( $flash == false && isset( $this->params[ "flash" ] ) ) {
			unset( $this->params[ "flash" ] );
		}

		return $this;
	}

	public function setNormalize( $normalize ) {

		if ( $normalize == true ) {
			$this->params[ "normalize" ] = "1";
		} else if ( $normalize == false && isset( $this->params[ "normalize" ] ) ) {
			unset( $this->params[ "normalize" ] );
		}

		return $this;
	}

}
