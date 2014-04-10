<?php

namespace SMSApi\Api\Response;

/**
 * Class PointsResponse
 * @package SMSApi\Api\Response
 */
class PointsResponse extends AbstractResponse
{
	/**
	 * @return mixed
	 */
	public function getPoints()
	{
		return $this->obj->points;
	}
}
