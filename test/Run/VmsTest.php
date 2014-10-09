<?php

require_once '../SmsapiTest.php';

class VmsTest extends SmsapiTest {

	private $error = 0;
	private $ids = array( );

	public function testSendAudio() {

		//$this->markTestIncomplete(__METHOD__.' this test has not been implemented.');

		$this->sendAudioFile();

		$this->sendAudioTts();


		$this->writeIds( $this->ids );

		$this->assertEquals( 0, $this->error );
	}

	private function sendAudioFile() {
		$smsApi = new \SMSApi\Api\VmsFactory( null, $this->client() );

		$result = null;

		$time = time() + 86400;

		$audio_file = __DIR__ . DIRECTORY_SEPARATOR . "voice_small.wav";

		$action = $smsApi->actionSend();

		/* @var $result \SMSApi\Api\Response\StatusResponse */
		/* @var $item \SMSApi\Api\Response\MessageResponse */

		$result = $action->setFile( $audio_file )
			->setTo( $this->numberTest )
			->setDateSent( $time )
			->execute();

		echo "VmsSendFile:\n";

		foreach ( $result->getList() as $item ) {
			if ( !$item->getError() ) {
				$this->renderMessageItem( $item );
				$this->ids[ ] = $item->getId();
			} else {
				$this->error++;
			}
		}
	}

	public function sendAudioTts() {

		$smsApi = new \SMSApi\Api\VmsFactory( null, $this->client() );

		$result = null;

		$time = time() + 86400;

		$tts = "Wiadomość w formacie TTS";

		$action = $smsApi->actionSend();

		/* @var $result \SMSApi\Api\Response\StatusResponse */
		/* @var $item \SMSApi\Api\Response\MessageResponse */

		$result = $action->setTts( $tts )
			->setTo( $this->numberTest )
			->setDateSent( $time )
			->setTtsLector( \SMSApi\Api\Action\Vms\Send::LECTOR_JACEK )
			->execute();

		echo "VmsSendTts:\n";

		foreach ( $result->getList() as $item ) {
			if ( !$item->getError() ) {
				$this->renderMessageItem( $item );
				$this->ids[ ] = $item->getId();
			} else {
				$this->error++;
			}
		}
	}

	public function testGet() {

		//$this->markTestIncomplete(__METHOD__.' this test has not been implemented.');

		$smsApi = new \SMSApi\Api\VmsFactory( null, $this->client() );

		$result = null;
		$error = 0;

		$action = $smsApi->actionGet();

		$ids = $this->readIds();

		/* @var $result \SMSApi\Api\Response\StatusResponse */
		/* @var $item \SMSApi\Api\Response\MessageResponse */

		$result = $action->ids( $ids )->execute();

		echo "\nVmsGet:\n";

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

		//$this->markTestIncomplete(__METHOD__.' this test has not been implemented.');

		$smsApi = new \SMSApi\Api\VmsFactory( null, $this->client() );

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

