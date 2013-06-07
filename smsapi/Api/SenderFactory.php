<?php

namespace SMSApi\Api;

class SenderFactory extends ActionFactory {

	public function actionList() {
		$action = new \SMSApi\Api\Action\Sender\SenderList();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		return $action;
	}

	public function actionAdd( $senderName = null ) {
		$action = new \SMSApi\Api\Action\Sender\Add();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		if ( !empty( $senderName ) ) {
			$action->setName( $senderName );
		}

		return $action;
	}

	public function actionDelete( $senderName = null ) {
		$action = new \SMSApi\Api\Action\Sender\Delete();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		if ( !empty( $senderName ) ) {
			$action->setSender( $senderName );
		}

		return $action;
	}

	public function actionSetDefault( $senderName = null ) {
		$action = new \SMSApi\Api\Action\Sender\SenderDefault();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		if ( !empty( $senderName ) ) {
			$action->setSender( $senderName );
		}

		return $action;
	}

}
