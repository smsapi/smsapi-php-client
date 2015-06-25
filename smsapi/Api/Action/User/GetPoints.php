<?php

namespace SMSApi\Api\Action\User;

use SMSApi\Api\Action\AbstractAction;
use SMSApi\Api\Response\PointsResponse;
use SMSApi\Proxy\Uri;

/**
 * Class GetPoints
 *
 * @package SMSApi\Api\Action\User
 *
 * @method PointsResponse|null execute() execute()
 */
class GetPoints extends AbstractAction {

	/**
	 * @param $data
	 * @return PointsResponse
	 */
	protected function response( $data ) {

		return new PointsResponse( $data );
	}

	/**
	 * @return Uri
	 */
	public function uri() {

		$query = "";

		$query .= $this->paramsLoginToQuery();

		$query .= $this->paramsOther();

		$query .= "&credits=1";

		return new Uri( $this->proxy->getProtocol(), $this->proxy->getHost(), $this->proxy->getPort(), "/api/user.do", $query );
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

