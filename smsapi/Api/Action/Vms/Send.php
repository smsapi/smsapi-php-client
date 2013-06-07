<?php

namespace SMSApi\Api\Action\Vms;

use SMSApi\Api\Action\AbstractAction;
use SMSApi\Proxy\Uri;

class Send extends AbstractAction {

	const LECTOR_AGNIESZKA = "agnieszka";
	const LECTOR_EWA = "ewa";
	const LECTOR_JACEK = "jacek";
	const LECTOR_JAN = "jan";
	const LECTOR_MAJA = "maja";

	private $tts;
	private $file;

	protected function response( $data ) {

		return new \SMSApi\Api\Response\StatusResponse( $data );
	}

	public function uri() {

		$query = "";

		$query .= $this->paramsLoginToQuery();

		$query .= $this->paramsBasicToQuery();

		$query .= $this->paramsOther();

		if ( empty( $this->file ) && $this->tts != null ) {
			$query .= "&tts=" . $this->tts;
		}

		return new Uri( $this->proxy->getProtocol(), $this->proxy->getHost(), $this->proxy->getPort(), "/api/vms.do", $query );
	}

	public function file() {
		return $this->file;
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

	public function setFile( $file ) {
		$this->file = $file;
		return $this;
	}

	public function setTts( $tts ) {
		$this->tts = $tts;
		return $this;
	}

	public function setSkipGsm( $skipGsm ) {

		if ( $skipGsm == true ) {
			$this->params[ "skip_gsm" ] = "1";
		} else if ( $skipGsm == false && isset( $this->params[ "skip_gsm" ] ) ) {
			unset( $this->params[ "skip_gsm" ] );
		}

		return $this;
	}

	public function setTtsLector( $lector ) {
		$this->params[ "tts_lector" ] = $lector;
		return $this;
	}

	public function setFrom( $from ) {
		$this->params[ "from" ] = $from;
		return $this;
	}

}