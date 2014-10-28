<?php

require_once 'SmsapiTestCase.php';

class MmsTest extends SmsapiTestCase {

	public function testSend() {

		$smsApi = new \SMSApi\Api\MmsFactory( null, $this->client() );

		$result = null;
		$error = 0;
		$ids = array( );

		$time = time() + 86400;

		$smil = "<smil><head><layout><root-layout height='100%' width='100%'/><region id='Image' width='100%' height='100%' left='0' top='0'/></layout></head><body><par><img src='http://www.smsapi.pl/assets/img/mms.jpg' region='Image' /></par></body></smil>";

		$action = $smsApi->actionSend();

		/* @var $result \SMSApi\Api\Response\StatusResponse */
		/* @var $item \SMSApi\Api\Response\MessageResponse */

		$result = $action->setSubject("test mms")
                            ->setTo($this->getNumberTest())
                            ->setDateSent($time)
                            ->setSmil($smil)
                            ->execute();

		echo "MmsSend:\n";

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

		$smsApi = new \SMSApi\Api\MmsFactory( null, $this->client() );

		$result = null;
		$error = 0;

		$action = $smsApi->actionGet();

		$ids = $this->readIds();

		/* @var $result \SMSApi\Api\Response\StatusResponse */
		/* @var $item \SMSApi\Api\Response\MessageResponse */

		$result = $action->ids( $ids )->execute();

		echo "\nMmsGet:\n";

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

		$smsApi = new \SMSApi\Api\MmsFactory( null, $this->client() );

		$result = null;

		$action = $smsApi->actionDelete();

		$ids = $this->readIds();

		/* @var $result \SMSApi\Api\Response\CountableResponse */

		$result = $action->ids( $ids )->execute();

		echo "\nMmsDelete:\n";
		echo "Delete: " . $result->getCount();

		$this->assertNotEquals( 0, $result->getCount() );
	}

}

