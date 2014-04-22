<?php

namespace SMSApi\Api\Response;

/**
 * Class PointsResponse
 * @package SMSApi\Api\Response
 */
class PointsResponse extends AbstractResponse
{
	/**
	 * Number of points available for user.
	 *
	 * @return number
	 */
	public function getPoints()
	{
		return $this->obj->points;
	}
}
