<?php

namespace SMSApi\Api\Action\Mms;

use SMSApi\Api\Action\AbstractAction;
use SMSApi\Proxy\Uri;

class Send extends AbstractAction {

	protected function response( $data ) {

		return new \SMSApi\Api\Response\StatusResponse( $data );
	}

	public function uri() {

		$query = "";

		$query .= $this->paramsLoginToQuery();

		$query .= $this->paramsBasicToQuery();

		$query .= $this->paramsOther();

		return new Uri( $this->proxy->getProtocol(), $this->proxy->getHost(), $this->proxy->getPort(), "/api/mms.do", $query );
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

	public function setSubject( $subject ) {
		$this->params[ "subject" ] = $subject;
		return $this;
	}

	public function setSmil( $smil ) {
		$this->params[ "smil" ] = $smil;
		return $this;
	}

}