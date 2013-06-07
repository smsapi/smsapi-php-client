<?php

namespace SMSApi\Api;

class UserFactory extends ActionFactory {

	public function actionList() {
		$action = new \SMSApi\Api\Action\User\UserList();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		return $action;
	}

	public function actionAdd( $username = null ) {
		$action = new \SMSApi\Api\Action\User\Add();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		if ( !empty( $username ) ) {
			$action->setUsername( $username );
		}

		return $action;
	}

	public function actionEdit( $username = null ) {
		$action = new \SMSApi\Api\Action\User\Edit();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		if ( !empty( $username ) ) {
			$action->setUsername( $username );
		}

		return $action;
	}

	public function actionGet( $username = null ) {
		$action = new \SMSApi\Api\Action\User\Get();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		if ( !empty( $username ) ) {
			$action->setUsername( $username );
		}

		return $action;
	}

	public function actionGetPoints() {
		$action = new \SMSApi\Api\Action\User\GetPoint();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		return $action;
	}

}
