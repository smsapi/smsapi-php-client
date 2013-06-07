<?php

require_once '../SmsapiTest.php';

class UserTest extends SmsapiTest {

	private $userTest = "fajny3";

	private function renderUserItem( $item ) {

		if ( $item ) {
			print("Username: " . $item->getUsername()
				. " Limit: " . $item->getLimit()
				. " MouthLimit:" . $item->getMonthLimit()
				. " Phonebook:" . $item->getPhonebook()
				. " Senders: " . $item->getSenders()
				. " Active: " . $item->getActive()
				. "\n" );
		} else {
			print("Item is null" );
		}
	}

	public function testAdd() {

		$smsApi = new \SMSApi\Api\UserFactory( null, $this->client() );

		$result = null;
		$error = 0;

		$action = $smsApi->actionAdd( $this->userTest )
			->setPassword( md5( "100costma100" ) )
			->setPasswordApi( md5( "200costam200" ) )
			->setActive( true )
			->setLimit( "5.5" )
			->setPhonebook( true );

		$result = $action->execute();

		/* @var $result \SMSApi\Api\Response\UserResponse */

		if ( empty( $result ) ) {
			$error++;
		}

		echo "\nUserAdd:\n";

		$this->renderUserItem( $result );

		$this->assertEquals( 0, $error );
	}

	public function testGet() {

		$smsApi = new \SMSApi\Api\UserFactory( null, $this->client() );

		$result = null;
		$error = 0;

		$action = $smsApi->actionGet( $this->userTest );

		$result = $action->execute();

		/* @var $result \SMSApi\Api\Response\UserResponse */

		echo "\nUserGet:\n";

		if ( empty( $result ) ) {
			$error++;
		}

		$this->renderUserItem( $result );

		$this->assertEquals( 0, $error );
	}

	public function testEdit() {

		$smsApi = new \SMSApi\Api\UserFactory( null, $this->client() );

		$result = null;
		$error = 0;

		$action = $smsApi->actionEdit( $this->userTest )
			->setLimit( "10" )
			->setInfo( "to jest test" );

		$result = $action->execute();

		/* @var $result \SMSApi\Api\Response\UserResponse */

		echo "\nUserEdit:\n";

		if ( empty( $result ) ) {
			$error++;
		}

		$this->renderUserItem( $result );

		$this->assertEquals( 0, $error );
	}

	public function testList() {

		$smsApi = new \SMSApi\Api\UserFactory( null, $this->client() );

		$result = null;
		$error = 0;

		$action = $smsApi->actionList();

		/* @var $result \SMSApi\Api\Response\UsersResponse */
		/* @var $item \SMSApi\Api\Response\UserResponse */

		$result = $action->execute();

		echo "\nUserList:\n";

		if ( empty( $result ) ) {
			$error++;
		}

		foreach ( $result->getList() as $item ) {
			$this->renderUserItem( $item );
		}

		$this->assertEquals( 0, $error );
	}

}

