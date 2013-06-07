<?php

require_once '../SmsapiTest.php';

class SenderTest extends SmsapiTest {

	private $senderTest = "Olek";

	private function renderSenderItem( $item ) {

		if ( $item ) {
			print("Sendername: " . $item->getName()
				. " Status: " . $item->getStatus()
				. " Default:" . $item->isDefault()
				. "\n" );
		} else {
			print("Item is null\n" );
		}
	}

	public function testAdd() {

		$smsApi = new \SMSApi\Api\SenderFactory( null, $this->client() );

		$result = null;

		$action = $smsApi->actionAdd( $this->senderTest );

		$result = $action->execute();

		/* @var $item \SMSApi\Api\Response\CountableResponse */

		print("\nSenderAdd: " . $result->getCount() . "\n" );

		$this->assertNotEquals( 0, $result->getCount() );
	}

	public function testList() {

		$smsApi = new \SMSApi\Api\SenderFactory( null, $this->client() );

		$result = null;
		$error = 0;

		$action = $smsApi->actionList();

		/* @var $result \SMSApi\Api\Response\SendersResponse */
		/* @var $item \SMSApi\Api\Response\SenderResponse */

		$result = $action->execute();

		echo "\nSenderList:\n";

		if ( empty( $result ) ) {
			$error++;
		}

		foreach ( $result->getList() as $item ) {
			$this->renderSenderItem( $item );
		}

		$this->assertEquals( 0, $error );
	}

	public function testDelete() {

		$smsApi = new \SMSApi\Api\SenderFactory( null, $this->client() );

		$result = null;

		$action = $smsApi->actionDelete( $this->senderTest );

		$result = $action->execute();

		/* @var $result \SMSApi\Api\Response\CountableResponse */

		print("\nSenderDelete: " . $result->getCount() );

		$this->assertNotEquals( 0, $result->getCount() );
	}

}

