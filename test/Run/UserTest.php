<?php

require_once 'SmsapiTest.php';

class UserTest extends SmsapiTest
{
	private static $userTest;

    public static function setUpBeforeClass()
    {
        self::$userTest = "test-smsapi-client";
    }

	private function renderUserItem($item)
	{
		if( $item ) {
			print("Username: " . $item->getUsername()
				. " Limit: " . $item->getLimit()
				. " MouthLimit:" . $item->getMonthLimit()
				. " Phonebook:" . $item->getPhonebook()
				. " Senders: " . $item->getSenders()
				. " Active: " . $item->getActive()
				. "\n");
		} else {
			print("Item is null");
		}
	}

	public function testAdd()
	{
        if ($this->userExists()) {
            $this->markTestSkipped("User: \"" . self::$userTest . "\" already exists. No need to add another.");
        }

		$smsApi = new \SMSApi\Api\UserFactory(null, $this->client());

		$result = null;
		$error = 0;

		$action = $smsApi->actionAdd(self::$userTest)
			->setPassword(md5("100costma100"))
			->setPasswordApi(md5("200costam200"))
			->setActive(true)
			->setLimit("5.5")
			->setPhonebook(true);

		$result = $action->execute();

		/* @var $result \SMSApi\Api\Response\UserResponse */

		if( empty($result) ) {
			$error++;
		}

		echo "\nUserAdd:\n";

		$this->renderUserItem($result);

		$this->assertEquals(0, $error);
	}

    private function userExists()
    {
        try {
            $this->getApiUser();
            return true;
        } catch(\SMSApi\Exception\ActionException $e) {
            return false;
        }
    }

	public function testGet()
	{
        $result = $this->getApiUser();

		echo "\nUserGet:\n";

        $error = 0;

		if( empty($result) ) {
			$error++;
		}

		$this->renderUserItem($result);

		$this->assertEquals(0, $error);
	}

	public function testEdit()
	{
		$smsApi = new \SMSApi\Api\UserFactory(null, $this->client());

		$result = null;
		$error = 0;

		$action = $smsApi->actionEdit(self::$userTest)
			->setLimit("10")
			->setInfo("to jest test");

		$result = $action->execute();

		/* @var $result \SMSApi\Api\Response\UserResponse */

		echo "\nUserEdit:\n";

		if( empty($result) ) {
			$error++;
		}

		$this->renderUserItem($result);

		$this->assertEquals(0, $error);
	}

	public function testList()
	{
		$smsApi = new \SMSApi\Api\UserFactory(null, $this->client());

		$result = null;
		$error = 0;

		$action = $smsApi->actionList();

		/* @var $result \SMSApi\Api\Response\UsersResponse */
		/* @var $item \SMSApi\Api\Response\UserResponse */

		$result = $action->execute();

		echo "\nUserList:\n";

		if( empty($result) ) {
			$error++;
		}

		foreach( $result->getList() as $item ) {
			$this->renderUserItem($item);
		}

		$this->assertEquals(0, $error);
	}

	public function testGetPoints()
	{
		$smsApi = new \SMSApi\Api\UserFactory(null, $this->client());

		$action = $smsApi->actionGetPoints();

		$result = $action->execute();

		$this->assertInstanceOf(\SMSApi\Api\Response\PointsResponse::class, $result);
		$this->greaterThanOrEqual($result->getPoints(), 0);

	}

    /**
     * @return \SMSApi\Api\Response\UserResponse
     */
    private function getApiUser()
    {
        $smsApi = new \SMSApi\Api\UserFactory(null, $this->client());

        $action = $smsApi->actionGet(self::$userTest);

        $result = $action->execute();

        return $result;
    }
}

