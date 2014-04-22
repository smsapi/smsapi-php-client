<?php

namespace SMSApi\Api;

/**
 * Class MmsFactory
 * @package SMSApi\Api
 */
class MmsFactory extends ActionFactory {

	/**
	 * @return Action\Mms\Send
	 */
	public function actionSend() {
		$action = new \SMSApi\Api\Action\Mms\Send();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		return $action;
	}

	/**
	 * @param null $id
	 * @return Action\Mms\Get
	 * @throws \SMSApi\Exception\ActionException
	 */
	public function actionGet( $id = null ) {
		$action = new \SMSApi\Api\Action\Mms\Get();
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
	 * @return Action\Mms\Delete
	 * @throws \SMSApi\Exception\ActionException
	 */
	public function actionDelete( $id = null ) {
		$action = new \SMSApi\Api\Action\Mms\Delete();
		$action->client( $this->client );
		$action->proxy( $this->proxy );

		if ( !empty( $id ) && is_string( $id ) ) {
			$action->filterById( $id );
		} else if ( !empty( $id ) && is_array( $id ) ) {
			$action->filterByIds( $id );
		}

		return $action;
	}

}
