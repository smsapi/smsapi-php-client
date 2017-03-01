<?php

use SMSApi\Api\Response\UserResponse;

class UserTest extends SmsapiTestCase
{
    private static $userTest;

    /**
     * @var \SMSApi\Api\UserFactory
     */
    private $userFactory;

    public static function setUpBeforeClass()
    {
        self::$userTest = "test-smsapi-client-" . md5(microtime(true));
    }

    protected function setUp()
    {
        $this->userFactory = new \SMSApi\Api\UserFactory($this->proxy(), $this->client());
    }

    private function renderUserItem(UserResponse $item = null)
    {
        if ($item) {
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

    public function testAddWithoutPrefix()
    {
        if ($this->userExists()) {
            $this->markTestSkipped("User: \"" . self::$userTest . "\" already exists. No need to add another.");
        }

        $result = null;
        $error = 0;

        $action = $this->userFactory->actionAdd(self::$userTest)
            ->setPassword(md5("100costma100"))
            ->setPasswordApi(md5("200costam200"))
            ->setActive(true)
            ->setLimit(5.5)
            ->withoutPrefix()
            ->setPhonebook(true);

        $result = $action->execute();

        /* @var $result UserResponse */

        if (empty($result)) {
            $error++;
        }

        echo "\nUserAdd:\n";

        $this->renderUserItem($result);

        $this->assertEquals(0, $error);
    }

    public function testAdd()
    {
        if ($this->userExists()) {
            $this->markTestSkipped("User: \"" . self::$userTest . "\" already exists. No need to add another.");
        }

        $result = null;
        $error = 0;

        $action = $this->userFactory->actionAdd(self::$userTest)
            ->setPassword(md5("100costma100"))
            ->setPasswordApi(md5("200costam200"))
            ->setActive(true)
            ->setLimit(5.5)
            ->setPhonebook(true);

        $result = $action->execute();

        /* @var $result UserResponse */

        if (empty($result)) {
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
        } catch (\SMSApi\Exception\ActionException $e) {
            return false;
        }
    }

    public function testGet()
    {
        $result = $this->getApiUser();

        echo "\nUserGet:\n";

        $error = 0;

        if (empty($result)) {
            $error++;
        }

        $this->renderUserItem($result);

        $this->assertEquals(0, $error);
    }

    public function testEdit()
    {
        $result = null;
        $error = 0;

        $action = $this->userFactory->actionEdit(self::$userTest)
            ->setLimit(10)
            ->setInfo("to jest test");

        $result = $action->execute();

        /* @var $result UserResponse */

        echo "\nUserEdit:\n";

        if (empty($result)) {
            $error++;
        }

        $this->renderUserItem($result);

        $this->assertEquals(0, $error);
    }

    public function testList()
    {
        $result = null;
        $error = 0;

        $action = $this->userFactory->actionList();

        /* @var $result \SMSApi\Api\Response\UsersResponse */
        /* @var $item UserResponse */

        $result = $action->execute();

        echo "\nUserList:\n";

        if (empty($result)) {
            $error++;
        }

        foreach ($result->getList() as $item) {
            $this->renderUserItem($item);
        }

        $this->assertEquals(0, $error);
    }

    public function testGetPoints()
    {
        $action = $this->userFactory->actionGetPoints();

        $result = $action->execute();

        $this->assertInstanceOf(\SMSApi\Api\Response\PointsResponse::className, $result);
        $this->assertGreaterThanOrEqual(0, $result->getPoints());
    }

    /**
     * @return UserResponse
     */
    private function getApiUser()
    {
        $action = $this->userFactory->actionGet(self::$userTest);

        $result = $action->execute();

        return $result;
    }

    public function testGetPointsDetails()
    {
        $result = $this->userFactory
            ->actionGetPoints()
            ->setDetails(true)
            ->execute();

        $this->assertGreaterThanOrEqual(0, $result->getPoints());
        $this->assertGreaterThanOrEqual(0, $result->getProCount());
        $this->assertGreaterThanOrEqual(0, $result->getEcoCount());
        $this->assertGreaterThanOrEqual(0, $result->getMmsCount());
        $this->assertGreaterThanOrEqual(0, $result->getVmsGsmCount());
        $this->assertGreaterThanOrEqual(0, $result->getVmsLandCount());
    }
}
