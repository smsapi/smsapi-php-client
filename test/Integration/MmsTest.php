<?php

class MmsTest extends SmsapiTestCase
{
    /**
     * @var \SMSApi\Api\MmsFactory
     */
    private $mmsFactory;

    protected function setUp()
    {
        $this->mmsFactory = new \SMSApi\Api\MmsFactory($this->proxy, $this->client());
    }

	public function testSend()
    {
		$dateSend = time() + 86400;

        $smil = $this->prepareMmsSmil();

        $action = $this->mmsFactory->actionSend();

		$result =
            $action->setSubject("test mms")
                    ->setTo($this->getNumberTest())
                    ->setDateSent($dateSend)
                    ->setSmil($smil)
                    ->execute();

		echo "MmsSend:\n";

		$this->renderStatusResponse($result);

        $ids = $this->collectIds($result);

        $this->assertCount(1, $ids);
		$this->assertEquals(0, $this->countErrors($result));

        return $ids;
	}

    /**
     * @return string
     */
    private function prepareMmsSmil()
    {
        $smil =
            "<smil>" .
                "<head>" .
                    "<layout>" .
                        "<root-layout height='100%' width='100%'/>" .
                        "<region id='Image' width='100%' height='100%' left='0' top='0'/>" .
                    "</layout>" .
                "</head>" .
                "<body><par><img src='http://www.smsapi.pl/assets/img/mms.jpg' region='Image' /></par></body>" .
            "</smil>";

        return $smil;
    }

    /**
     * @depends testSend
     */
	public function testGet(array $ids)
    {
		$action = $this->mmsFactory->actionGet();

		$result = $action->filterByIds($ids)->execute();

		echo "\nMmsGet:\n";

		$this->renderStatusResponse($result);

		$this->assertEquals(0, $this->countErrors($result));
        $this->assertEquals(1, $result->getCount());
	}

    /**
     * @depends testSend
     */
	public function testDelete(array $ids)
    {
		$action = $this->mmsFactory->actionDelete();

		$result = $action->filterByIds($ids)->execute();

		echo "\nMmsDelete: " . $result->getCount();

		$this->assertEquals(1, $result->getCount());
	}
}
