<?php

require_once '../SmsapiTest.php';

class SmsTest extends SmsapiTest {

	public function testSend() {

		$smsApi = new \SMSApi\Api\SmsFactory( null, $this->client() );

		$result = null;
		$error = 0;
		$ids = array( );

		$time = time() + 86400;

		$action = $smsApi->actionSend();

		/* @var $result \SMSApi\Api\Response\StatusResponse */
		/* @var $item \SMSApi\Api\Response\MessageResponse */

		$result =
			$action
				->setText( "test [%1%] message" )
				->setTo( $this->numberTest )
				->SetParam( 0, 'asd' )
				->setDateSent( $time )
				->execute();

		echo "SmsSend:\n";

		foreach ( $result->getList() as $item ) {
			if ( !$item->getError() ) {
				$this->renderMessageItem( $item );
				$ids[ ] = $item->getId();
			} else {
				$error++;
			}
		}

		$this->writeIds( $ids );

		$this->assertEquals( 0, $error );
	}

	public function testGet() {

		$smsApi = new \SMSApi\Api\SmsFactory( null, $this->client() );

		$result = null;
		$error = 0;

		$action = $smsApi->actionGet();

		$ids = $this->readIds();

		/* @var $result \SMSApi\Api\Response\StatusResponse */
		/* @var $item \SMSApi\Api\Response\MessageResponse */

		$result = $action->ids( $ids )->execute();

		echo "\nSmsGet:\n";

		foreach ( $result->getList() as $item ) {
			if ( !$item->getError() ) {
				$this->renderMessageItem( $item );
			} else {
				$error++;
			}
		}

		$this->assertEquals( 0, $error );
	}

	public function testDelete() {

		$smsApi = new \SMSApi\Api\SmsFactory( null, $this->client() );

		$result = null;

		$action = $smsApi->actionDelete();

		$ids = $this->readIds();

		/* @var $result \SMSApi\Api\Response\CountableResponse */

		$result = $action->ids( $ids )->execute();

		echo "\nSmsDelete:\n";
		echo "Delete: " . $result->getCount();

		$this->assertNotEquals( 0, $result->getCount() );
	}

}

