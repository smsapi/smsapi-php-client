<?php

namespace SMSApi\Api\Action\Mms;

use SMSApi\Api\Action\AbstractAction;
use SMSApi\Proxy\Uri;

/**
 * Class Send
 * @package SMSApi\Api\Action\Mms
 */
class Send extends AbstractAction {

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

		return new Uri( $this->proxy->getProtocol(), $this->proxy->getHost(), $this->proxy->getPort(), "/api/mms.do", $query );
	}

	/**
	 *
	 *
	 * @param $to array|string
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
	 * @param $subject
	 * @return $this
	 */
	public function setSubject( $subject ) {
		$this->params[ "subject" ] = $subject;
		return $this;
	}

	/**
	 * @param $smil
	 * @return $this
	 */
	public function setSmil( $smil ) {
		$this->params[ "smil" ] = urlencode($smil);
		return $this;
	}

}