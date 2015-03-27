<?php

namespace SMSApi\Api\Response;

/**
 * Class PointsResponse
 * @package SMSApi\Api\Response
 */
class PointsResponse extends AbstractResponse
{
    const className = __CLASS__;

    /** @var int|null */
    private $proCount;

    /** @var int|null */
    private $ecoCount;

    /** @var int|null */
    private $mmsCount;

    /** @var int|null */
    private $vmsGsmCount;

    /** @var int|null */
    private $vmsLandCount;

    public function __construct($data)
    {
        parent::__construct($data);

        if (isset($this->obj->proCount)) {
            $this->proCount = $this->obj->proCount;
        }

        if (isset($this->obj->ecoCount)) {
            $this->ecoCount = $this->obj->ecoCount;
        }

        if (isset($this->obj->mmsCount)) {
            $this->mmsCount = $this->obj->mmsCount;
        }

        if (isset($this->obj->vmsGsmCount)) {
            $this->vmsGsmCount = $this->obj->vmsGsmCount;
        }

        if (isset($this->obj->vmsLandCount)) {
            $this->vmsLandCount = $this->obj->vmsLandCount;
        }
    }

    /**
	 * Number of points available for user.
	 *
	 * @return number
	 */
	public function getPoints()
	{
		return $this->obj->points;
	}

    public function getProCount()
    {
        return $this->proCount;
    }

    public function getEcoCount()
    {
        return $this->ecoCount;
    }

    public function getMmsCount()
    {
        return $this->mmsCount;
    }

    public function getVmsGsmCount()
    {
        return $this->vmsGsmCount;
    }

    public function getVmsLandCount()
    {
        return $this->vmsLandCount;
    }
}
