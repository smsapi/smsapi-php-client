<?php

namespace SMSApi\Api\Response;

class PointsResponse extends AbstractResponse
{
	public function getPoints()
	{
		return $this->obj->points;
	}
}
