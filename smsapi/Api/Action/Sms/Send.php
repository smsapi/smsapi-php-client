<?php

namespace SMSApi\Api\Action\Sms;

use SMSApi\Api\Action\AbstractAction;
use SMSApi\Api\Response\StatusResponse;
use SMSApi\Proxy\Uri;

/**
 * Class Send
 * @package SMSApi\Api\Action\Sms
 *
 * @method StatusResponse execute()
 */
class Send extends AbstractAction
{
	/**
	 * @var string
	 */
	protected $encoding = 'utf-8';

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

		return new Uri( $this->proxy->getProtocol(), $this->proxy->getHost(), $this->proxy->getPort(), "/api/sms.do", $query );
	}

	/**
	 * Set SMS text message.
	 *
	 * Content of one message is normally 160 characters per single
	 * SMS or 70 in case of using at least one special character
	 *
	 * @param $text
	 * @return $this
	 */
	public function setText( $text ) {
		$this->params[ 'message' ] = urlencode( $text );
		return $this;
	}

	/**
	 * Set the SMS encoding charset, default is UTF-8.
	 *
	 * Example:
	 * windows-1250
	 * iso-8859-2
	 *
	 * @param string $encoding
	 * @return $this
	 */
	public function setEncoding( $encoding ) {
		$this->encoding = $encoding;
		return $this;
	}


	/**
	 * Set mobile phone number of the recipients.
	 *
	 * @param string|array|int $to Phone number recipient/s.
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
	 * @param string $group String group name
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
	 * @param mixed $date set timestamp or ISO 8601 date format
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
	 *
	 * Set expiration date.
	 *
	 * Message expiration date (in unix timestamp) is a date after which message won't be
	 * delivered if it wasn't delivered yet. The difference between date sent and expiration
	 * date can't be less than 1 hour and more than 12 hours. Time will be set with
	 * tolerance +/- 5 minutes.
	 *
	 * @param int $date in timestamp
	 * @return $this
	 */
	public function setDateExpire( $date ) {
		$this->params[ "expiration_date" ] = $date;
		return $this;
	}

	/**
	 * Set name of the sender.
	 *
	 * To send SMS as ECO use sender name `ECO`.
	 * To send SMS as 2Way use sender name `2Way`.
	 *
	 * Only verified names are being accepted.
	 *
	 * @param string $sender sender name or eco or 2way
	 * @return $this
	 */
	public function setSender( $sender ) {
		$this->params[ "from" ] = $sender;
		return $this;
	}

	/**
	 * Set protection from send multipart messages.
	 *
	 * If the message will contain more than 160 chars (single message) it won't be
	 * sent and return error
	 *
	 * @param bool $single
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
	 * Set protection from sending messages containing special characters.
	 *
	 * @param bool $noUnicode if true turn on protection
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
	 * Set SMS message data coding.
	 *
	 * This parameter allows to send WAP PUSH messages.
	 *
	 * Example: bin
	 *
	 * @param string $dataCoding
	 * @return $this
	 */
	public function setDataCoding( $dataCoding ) {
		$this->params[ "datacoding" ] = $dataCoding;
		return $this;
	}

	/**
	 * Set SMS message in flash mode.
	 *
	 * Flash SMS are automatically presented on the mobile screen and
	 * have to be saved to be default stored in inbox.
	 *
	 * @param bool $flash
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
	 * Set normalize SMS text.
	 *
	 * Removing dialectic characters from message.
	 *
	 * @param bool $normalize
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
	 * Set higher priority of sending message.
	 * Prohibited for bulk messages.
	 *
	 * @param bool $fast if true set higher priority otherwise normal priority
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
	 * Set personalized parameters to bulk messages.
	 *
	 * @param int $i
	 * @param string|string[] $text
	 * @return $this
	 * @throws \OutOfRangeException
	 */
	public function SetParam($i, $text) {

		if ( $i > 3 || $i < 0 ) {
			throw new \OutOfRangeException;
		}

		$value = is_array($text) ? implode('|', $text) : $text;
		$this->params['param'.($i+1)] = urlencode( $value );

		return $this;
	}

    /**
     * Set template
     * @param $name
     * @return $this
     */
    public function setTemplate($name)
    {
        $this->params['template'] = urlencode($name);

        return $this;
    }

    /**
     * Return detailed information
     * @param bool $details
     * @return $this
     */
    public function setDetails($details)
    {
        if ($details) {
            $this->params['details'] = 1;
        } else {
            unset($this->params['details']);
        }

        return $this;
    }
}
