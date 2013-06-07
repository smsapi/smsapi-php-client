<?php

namespace SMSApi\Api;

class MmsFactory extends ActionFactory {

	public function actionSend() {
		$action = new \SMSApi\Api\Action\Mms\Send();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		return $action;
	}

	public function actionGet( $id = null ) {
		$action = new \SMSApi\Api\Action\Mms\Get();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		if ( !empty( $id ) && is_string( $id ) ) {
			$action->id( $id );
		} else if ( !empty( $id ) && is_array( $id ) ) {
			$action->ids( $id );
		}

		return $action;
	}

	public function actionDelete( $id = null ) {
		$action = new \SMSApi\Api\Action\Mms\Delete();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		if ( !empty( $id ) && is_string( $id ) ) {
			$action->id( $id );
		} else if ( !empty( $id ) && is_array( $id ) ) {
			$action->ids( $id );
		}

		return $action;
	}

}
