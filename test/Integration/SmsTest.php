<?php

class SmsTest extends SmsapiTestCase
{
    /**
     * @var \SMSApi\Api\SmsFactory
     */
    private $smsFactory;

    protected function setUp()
    {
        $this->smsFactory = new \SMSApi\Api\SmsFactory($this->proxy, $this->client());
    }

	public function testSend()
    {
		$dateSend = time() + 86400;

		$action = $this->smsFactory->actionSend();

		$result =
			$action
				->setText("test [%1%] message")
				->setTo($this->getNumberTest())
				->SetParam(0, 'asd')
				->setDateSent($dateSend)
				->execute();

		echo "SmsSend:\n";

		$this->renderStatusResponse($result);

        $ids = $this->collectIds($result);

        $this->assertCount(1, $ids);
		$this->assertEquals(0, $this->countErrors($result));

        return $ids;
	}

    /**
     * @depends testSend
     */
	public function testGet(array $ids)
    {
		$action = $this->smsFactory->actionGet();

		$result = $action->filterByIds($ids)->execute();

		echo "\nSmsGet:\n";

        $this->renderStatusResponse($result);

		$this->assertEquals(0, $this->countErrors($result));
        $this->assertEquals(1, $result->getCount());
	}

    /**
     * @depends testSend
     */
	public function testDelete(array $ids)
    {
		$action = $this->smsFactory->actionDelete();

		$result = $action->filterById($ids[0])->execute();

		echo "\nSmsDelete: " . $result->getCount();

		$this->assertEquals(1, $result->getCount());
	}

    public function testTemplate()
    {
        $template = $this->getSmsTemplateName();

        if (!$template) {
            $this->markTestSkipped('Template does not exists.');
        }

        $result = $this->sendSmsByTemplate();

        $this->assertEquals(0, $this->countErrors($result));
        $this->assertEquals(1, $result->getCount());
    }

    /**
     * @return \SMSApi\Api\Response\StatusResponse
     */
    private function sendSmsByTemplate()
    {
        $result =
            $this->smsFactory
                ->actionSend()
                ->setTemplate($this->getSmsTemplateName())
                ->setTo($this->getNumberTest())
                ->execute();

        return $result;
    }

    public function testDetails()
    {
        $someMessage = 'test message';
        $sendSms = $this->smsFactory
            ->actionSend()
            ->setTo($this->getNumberTest())
            ->setText($someMessage)
            ->setDetails(true);

        $result = $sendSms->execute();

        $this->assertEquals($someMessage, $result->getMessage());
        $this->assertEquals(strlen($someMessage), $result->getLength());
        $this->assertEquals(1, $result->getParts());
    }
}
