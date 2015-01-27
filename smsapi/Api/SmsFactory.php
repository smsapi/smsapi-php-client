<?php
//sms
namespace SMSApi\Api;

/**
 * Class SmsFactory
 * @package SMSApi\Api
 */
class SmsFactory extends ActionFactory {

	/**
	 * @return Action\Sms\Send
	 */
	public function actionSend() {
		$action = new \SMSApi\Api\Action\Sms\Send();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		return $action;
	}

	/**
	 * @param null $id
	 * @return Action\Sms\Get
	 * @throws \SMSApi\Exception\ActionException
	 */
	public function actionGet( $id = null ) {
		$action = new \SMSApi\Api\Action\Sms\Get();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		if ( !empty( $id ) && is_string( $id ) ) {
			$action->filterById( $id );
		} else if ( !empty( $id ) && is_array( $id ) ) {
			$action->filterByIds( $id );
		}

		return $action;
	}

	/**
	 * @param null $id
	 * @return Action\Sms\Delete
	 * @throws \SMSApi\Exception\ActionException
	 */
	public function actionDelete( $id = null ) {
		$action = new \SMSApi\Api\Action\Sms\Delete();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		if ( !empty( $id ) && is_string( $id ) ) {
			$action->filterById( $id );
		}

		return $action;
	}

}
