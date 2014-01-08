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

	protected function response( $data ) {

		return new \SMSApi\Api\Response\PointsResponse( $data );
	}

	public function uri() {

		$query = "";

		$query .= $this->paramsLoginToQuery();

		$query .= $this->paramsOther();

		$query .= "&credits=1";

		return new Uri( $this->proxy->getProtocol(), $this->proxy->getHost(), $this->proxy->getPort(), "/api/user.do", $query );
	}

}

