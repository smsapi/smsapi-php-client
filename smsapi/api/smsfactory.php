<?php

namespace SMSApi\Api;

class SMSFactory extends AbstractFactory {

	/**
	 * @return Action\SMS\Send
	 */
	public function actionSend() {
		$action = new \SMSApi\Api\Action\SMS\Send();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		return $action;
	}
}
