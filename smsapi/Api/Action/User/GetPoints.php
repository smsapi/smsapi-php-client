<?php

namespace SMSApi\Api\Action\User;

use SMSApi\Api\Action\AbstractAction;
use SMSApi\Proxy\Uri;

/**
 * Class GetPoints
 *
 * @package SMSApi\Api\Action\User
 *
 * @method \SMSApi\Api\Response\PointsResponse|null execute() execute()
 */
class GetPoints extends AbstractAction {

	/**
	 * @param $data
	 * @return \SMSApi\Api\Response\PointsResponse
	 */
	protected function response( $data ) {

		return new \SMSApi\Api\Response\PointsResponse( $data );
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
     * @param bool $name
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

