<?php

namespace SMSApi\Api;

/**
 * Class UserFactory
 * @package SMSApi\Api
 */
class UserFactory extends ActionFactory {

	/**
	 * @return Action\User\UserList
	 */
	public function actionList() {
		$action = new \SMSApi\Api\Action\User\UserList();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		return $action;
	}

	/**
	 * @param null $username
	 * @return Action\User\Add
	 */
	public function actionAdd( $username = null ) {
		$action = new \SMSApi\Api\Action\User\Add();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		if ( !empty( $username ) ) {
			$action->setUsername( $username );
		}

		return $action;
	}

	/**
	 * @param null $username
	 * @return Action\User\Edit
	 */
	public function actionEdit( $username = null ) {
		$action = new \SMSApi\Api\Action\User\Edit();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		if ( !empty( $username ) ) {
			$action->filterByUsername( $username );
		}

		return $action;
	}

	/**
	 * @param null $username
	 * @return Action\User\Get
	 */
	public function actionGet( $username = null ) {
		$action = new \SMSApi\Api\Action\User\Get();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		if ( !empty( $username ) ) {
			$action->filterByUsername( $username );
		}

		return $action;
	}

	/**
	 * @return Action\User\GetPoints
	 */
	public function actionGetPoints() {
		$action = new \SMSApi\Api\Action\User\GetPoints();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		return $action;
	}

}
