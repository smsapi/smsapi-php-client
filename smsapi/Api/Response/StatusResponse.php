<?php

namespace SMSApi\Api\Response;

/**
 * Class StatusResponse
 * @package SMSApi\Api\AbstractContactsResponse
 */
class StatusResponse extends CountableResponse {

	/**
	 * @var \ArrayObject|MessageResponse[]
	 */
	private $list;

    /** @var string|null */
    private $message;

    /** @var int|null */
    private $length;

    /** @var int|null */
    private $parts;

	/**
	 * @param $data
	 */
	function __construct( $data ) {
		parent::__construct( $data );

		$this->list = new \ArrayObject();

		if ( isset( $this->obj->list ) ) {
			foreach ( $this->obj->list as $res ) {
				$this->list->append( new MessageResponse( $res->id, $res->points, $res->number, $res->status, $res->error, $res->idx ) );
			}
		}

        if (isset($this->obj->message)) {
            $this->message = (string)$this->obj->message;
        }

        if (isset($this->obj->length)) {
            $this->length = (int)$this->obj->length;
        }

        if (isset($this->obj->parts)) {
            $this->parts = (int)$this->obj->parts;
        }
	}

	/**
	 * @return MessageResponse[]
	 */
	public function getList() {
		return $this->list;
	}

    public function getMessage()
    {
        return $this->message;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function getParts()
    {
        return $this->parts;
    }
}
