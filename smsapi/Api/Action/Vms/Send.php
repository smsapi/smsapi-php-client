<?php

namespace SMSApi\Api\Action\Vms;

use SMSApi\Api\Action\AbstractAction;
use SMSApi\Api\Response\StatusResponse;
use SMSApi\Proxy\Uri;

/**
 * Class Send
 * @package SMSApi\Api\Action\Vms
 *
 * @method StatusResponse execute()
 */
class Send extends AbstractAction
{
	const LECTOR_AGNIESZKA = "agnieszka";
	const LECTOR_EWA = "ewa";
	const LECTOR_JACEK = "jacek";
	const LECTOR_JAN = "jan";
	const LECTOR_MAJA = "maja";

	/**
	 * @var
	 */
	private $tts;

	/**
	 * @var
	 */
	private $file;

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

		if ( empty( $this->file ) && $this->tts != null ) {
			$query .= "&tts=" . $this->tts;
		}

		return new Uri( $this->proxy->getProtocol(), $this->proxy->getHost(), $this->proxy->getPort(), "/api/vms.do", $query );
	}

	/**
	 * @return mixed
	 */
	public function file() {
		return $this->file;
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
	 * Set local audio filename.
	 *
	 * @param $file
	 * @return $this
	 */
	public function setFile( $file ) {
		$this->file = $file;
		return $this;
	}

	/**
	 * Set text to voice synthesizer.
	 *
	 * @param string $tts text to read
	 * @return $this
	 */
	public function setTts( $tts ) {
		$this->tts = $tts;
		return $this;
	}

	/**
	 * Set flag to not send messages on cell phone numbers.
	 *
	 * @param $skipGsm
	 * @return $this
	 */
	public function setSkipGsm( $skipGsm ) {

		if ( $skipGsm == true ) {
			$this->params[ "skip_gsm" ] = "1";
		} else if ( $skipGsm == false && isset( $this->params[ "skip_gsm" ] ) ) {
			unset( $this->params[ "skip_gsm" ] );
		}

		return $this;
	}

	/**
	 * Set lector name.
	 *
	 * @param string $lector The value of $lector can be: agnieszka, ewa, jacek, jan or maja
	 * @return $this
	 */
	public function setTtsLector( $lector ) {
		$this->params[ "tts_lector" ] = $lector;
		return $this;
	}

	/**
	 * Set called number. Leaving the field blank causes the sending of the default number of callers.
	 *
	 * @param $from
	 * @return $this
	 */
	public function setFrom( $from ) {
		$this->params[ "from" ] = $from;
		return $this;
	}

	/**
	 * Set number of connection attempts.
	 *
	 * @param integer $try Number of connection attempts
	 * @return $this
	 * @throws \OutOfRangeException
	 */
	public function setTry($try)
	{
		if($try < 1 || $try > 6) {
			throw new \OutOfRangeException;
		}

		$this->params['try'] = $try;
		return $this;
	}

	/**
	 * Set the time in seconds where the connection have to be repeated
	 * in the case of not answer by receiver or reject this connection.
	 *
	 * @param integer $interval Time in seconds
	 *
	 * @return $this
	 * @throws \OutOfRangeException
	 */
	public function setInterval($interval)
	{
		if($interval < 300 || $interval > 7200) {
			throw new \OutOfRangeException;
		}

		$this->params['interval'] = $interval;
		return $this;
	}

}