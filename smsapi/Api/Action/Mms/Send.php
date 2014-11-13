<?php

namespace SMSApi\Api\Action\Mms;

use SMSApi\Api\Action\AbstractAction;
use SMSApi\Api\Response\StatusResponse;
use SMSApi\Proxy\Uri;

/**
 * Class Send
 * @package SMSApi\Api\Action\Mms
 *
 * @method StatusResponse execute()
 */
class Send extends AbstractAction
{
	/**
	 * @param $data
	 * @return StatusResponse
	 */
    protected function response($data)
    {
        return new StatusResponse($data);
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
	 * Set mobile phone number of the recipients.
	 *
	 * @param $to array|string phone number
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
	 * Set name of the group from the phone book to which message should be sent.
	 *
	 * @param string $group group name
	 * @return $this
	 */
	public function setGroup( $group ) {
		$this->group = $group;
		return $this;
	}

	/**
	 * Set scheduled date sending message.
	 *
	 * Setting a past date will result in sending message instantly.
	 *
	 * @param $date
	 * @return $this
	 */
	public function setDateSent( $date ) {
		$this->date = $date;
		return $this;
	}

	/**
	 * Set optional custom value sent with SMS and sent back in CALLBACK.
	 *
	 * @param string|array $idx
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
	 * Set checking idx is unique.
	 *
	 * Prevents from sending more than one message with the same idx.
	 * When this parameter is set and message with the same idx was
	 * already sent error 53 is returned.
	 *
	 * @param bool $check
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
	 * Set affiliate code.
	 *
	 * @param string $partner affiliate code
	 * @return $this
	 */
	public function setPartner( $partner ) {
		$this->params[ "partner_id" ] = $partner;
		return $this;
	}

	/**
	 * Set message subject.
	 *
	 * @param string $subject subject of message
	 * @return $this
	 */
	public function setSubject( $subject ) {
		$this->params[ "subject" ] = $subject;
		return $this;
	}

	/**
	 * Set MMS smill.
	 *
	 * @param string $smil xml smill
	 * @return $this
	 */
	public function setSmil( $smil ) {
		$this->params[ "smil" ] = urlencode($smil);
		return $this;
	}

}