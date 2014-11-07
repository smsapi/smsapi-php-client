<?php

class PhonebookTest extends SmsapiTestCase {

	private $groupTest = "mytest";
	private $groupTestEdit = "mytestedit";
	private $contactTest = "694562829";
	private $contactTestEdit = "617234123";

	private function renderGroupItem( $item ) {

		if ( $item ) {
			print("GroupName: "
				. $item->getName()
				. " Info: " . $item->getInfo()
				. " Numbers:" . $item->getNumbers()
				. "\n"
			);
		} else {
			print("Item is empty\n" );
		}
	}

	private function renderContactItem( \SMSApi\Api\Response\ContactResponse $item ) {

		if ( $item ) {
			print("ContactNumber: " . $item->getNumber()
				. " FirstName: " . $item->getFirstName()
				. " LastName:" . $item->getLastName()
				. " City: " . $item->getCity()
				. " Birthday: " . $item->getBirthday()
				. " Info: " . $item->getInfo()
				. " Gender: " . $item->getGender()
				. " DateAdd: " . $item->getDateAdd()
				. " DateMod: " . $item->getDateMod()
				. "\n"
			);
		} else {
			print("Item is empty\n" );
		}
	}

	public function testGroupAdd() {

		$smsApi = new \SMSApi\Api\PhonebookFactory( null, $this->client() );

		$result = null;
		$error = 0;

		$action = $smsApi->actionGroupAdd( $this->groupTest );

		/* @var $result \SMSApi\Api\Response\GroupResponse */

		$result = $action->execute();

		echo "GroupAdd:\n";

		if ( empty( $result ) ) {
			$error++;
		}

		$this->renderGroupItem( $result );

		$this->assertEquals( 0, $error );
	}

	public function testGroupEdit() {

		$smsApi = new \SMSApi\Api\PhonebookFactory( null, $this->client() );

		$result = null;
		$error = 0;

		$action = $smsApi->actionGroupEdit( $this->groupTest );

		/* @var $result \SMSApi\Api\Response\GroupResponse */

		$result = $action->setName( $this->groupTestEdit )->setInfo( "to jest grupa testowa" )->execute();

		echo "\nGroupEdit:\n";

		if ( empty( $result ) ) {
			$error++;
		}

		$this->renderGroupItem( $result );

		$this->assertEquals( 0, $error );
	}

	public function testContactAdd() {

		$smsApi = new \SMSApi\Api\PhonebookFactory( null, $this->client() );

		$result = null;
		$error = 0;

		$action = $smsApi->actionContactAdd( $this->contactTest );

		$action->setFirstName( "Bolek" )
			->setLastName( "Dzik" )
			->setBirthday( "15.02.1976" )
			->setInfo( "to jest test kontaktu" )
			->setEmail( "bolek@aaa.pl" )
			->setCity( "Gliwice" )
			->setGender( \SMSApi\Api\Response\ContactResponse::GENDER_MALE )
			->setGroup( $this->groupTestEdit );

		/* @var $result \SMSApi\Api\Response\ContactResponse */

		$result = $action->execute();

		echo "ContactAdd:\n";

		if ( empty( $result ) ) {
			$error++;
		}

		$this->renderContactItem( $result );

		$this->assertEquals( 0, $error );
	}

	public function testGroupGet() {

		$smsApi = new \SMSApi\Api\PhonebookFactory( null, $this->client() );

		$result = null;
		$error = 0;

		$action = $smsApi->actionGroupGet( $this->groupTestEdit );

		$result = $action->execute();

		echo "\nGroupGet:\n";

		if ( empty( $result ) ) {
			$error++;
		}

		$this->renderGroupItem( $result );

		$this->assertEquals( 0, $error );
	}

	public function testContactEdit() {

		$smsApi = new \SMSApi\Api\PhonebookFactory( null, $this->client() );

		$result = null;
		$error = 0;

		$action = $smsApi->actionContactEdit( $this->contactTest );

		/* @var $result \SMSApi\Api\Response\ContactResponse */

		$result = $action->setNumber( $this->contactTestEdit )->setFirstName( "Lolek" )->execute();

		echo "\nContactEdit:\n";

		if ( empty( $result ) ) {
			$error++;
		}

		$this->renderContactItem( $result );

		$this->assertEquals( 0, $error );
	}

	public function testContactGet() {

		$smsApi = new \SMSApi\Api\PhonebookFactory( null, $this->client() );

		$result = null;
		$error = 0;

		$action = $smsApi->actionContactGet( $this->contactTestEdit );

		/* @var $result \SMSApi\Api\Response\ContactResponse */

		$result = $action->execute();

		echo "\nContactGet:\n";

		if ( empty( $result ) ) {
			$error++;
		}

		$this->renderContactItem( $result );

		$this->assertEquals( 0, $error );
	}

	public function testContactDelete() {

		$smsApi = new \SMSApi\Api\PhonebookFactory( null, $this->client() );

		$result = null;
		$error = 0;

		$action = $smsApi->actionContactDelete( $this->contactTestEdit );

		/* @var $result SMSApi\Api\Response\RawResponse */

		$result = $action->execute();

		echo "\nContactDelete:\n";

		if ( empty( $result ) ) {
			$error++;
		}

		print("Group: " . $result->getText() );

		$this->assertEquals( 0, $error );
	}

	public function testGroupDelete() {

		$smsApi = new \SMSApi\Api\PhonebookFactory( null, $this->client() );

		$result = null;
		$error = 0;

		$action = $smsApi->actionGroupDelete( $this->groupTestEdit );

		/* @var $result SMSApi\Api\Response\RawResponse */

		$result = $action->execute();

		echo "\nGroupDelete:\n";

		if ( empty( $result ) ) {
			$error++;
		}

		print("Group: " . $result->getText() );

		$this->assertEquals( 0, $error );
	}

	public function testContactList() {

		$smsApi = new \SMSApi\Api\PhonebookFactory( null, $this->client() );

		$result = null;
		$error = 0;

		$action = $smsApi->actionContactList();

		/* @var $result SMSApi\Api\Response\ContactsResponse */
		/* @var $item SMSApi\Api\Response\ContactResponse */

		$result = $action->execute();

		echo "\nContactList:\n";

		if ( empty( $result ) ) {
			$error++;
		}

		foreach ( $result->getList() as $item ) {
			$this->renderContactItem( $item );
		}

		$this->assertEquals( 0, $error );
	}

	public function testGroupList() {

		$smsApi = new \SMSApi\Api\PhonebookFactory( null, $this->client() );

		$result = null;
		$error = 0;

		$action = $smsApi->actionGroupList();

		/* @var $result SMSApi\Api\Response\GroupsResponse */
		/* @var $item SMSApi\Api\Response\GroupResponse */

		$result = $action->execute();

		echo "\nGroupList:\n";

		if ( empty( $result ) ) {
			$error++;
		}

		foreach ( $result->getList() as $item ) {
			$this->renderGroupItem( $item );
		}

		$this->assertEquals( 0, $error );
	}

}

