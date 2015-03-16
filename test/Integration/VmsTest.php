<?php

class VmsTest extends SmsapiTestCase
{
    /**
     * @var \SMSApi\Api\VmsFactory
     */
    private $vmsFactory;

    protected function setUp()
    {
        $this->vmsFactory = new \SMSApi\Api\VmsFactory($this->proxy, $this->client());
    }

	public function testSendAudioFile()
    {
        $dateToSend = $this->prepareDateToSend();

		$audioFilePath = __DIR__ . DIRECTORY_SEPARATOR . "voice_small.wav";

		$action = $this->vmsFactory->actionSend();

		$result =
            $action->setFile($audioFilePath)
                ->setTo($this->getNumberTest())
                ->setDateSent($dateToSend)
                ->execute();

		echo "VmsSendFile:\n";

        $this->renderStatusResponse($result);

        $ids = $this->collectIds($result);

        $this->assertCount(1, $ids);
        $this->assertEquals(0, $this->countErrors($result));

        return $ids;
    }

	public function testSendAudioTts()
    {
		$dateToSend = $this->prepareDateToSend();

		$tts = "Wiadomość w formacie TTS";

		$action = $this->vmsFactory->actionSend();

		$result = $action->setTts($tts)
			->setTo($this->getNumberTest())
			->setDateSent($dateToSend)
			->setTtsLector(\SMSApi\Api\Action\Vms\Send::LECTOR_JACEK)
			->execute();

		echo "VmsSendTts:\n";

        $this->renderStatusResponse($result);

        $ids = $this->collectIds($result);

        $this->assertCount(1, $ids);
        $this->assertEquals(0, $this->countErrors($result));

        return $ids;
	}

    /**
     * @depends testSendAudioFile
     * @depends testSendAudioTts
     */
    public function testGet($audioIds, $ttsIds)
    {
		$action = $this->vmsFactory->actionGet();

		$ids = array_merge($audioIds, $ttsIds);

		$result = $action->filterByIds($ids)->execute();

		echo "\nVmsGet:\n";

        $this->renderStatusResponse($result);

		$this->assertEquals(0, $this->countErrors($result));
        $this->assertEquals(2, $result->getCount());
	}

    /**
     * @depends testSendAudioFile
     * @depends testSendAudioTts
     */
    public function testDelete($audioIds, $ttsIds)
    {
		$action = $this->vmsFactory->actionDelete();

		$ids = array_merge($audioIds, $ttsIds);

		$result = $action->filterByIds($ids)->execute();

		echo "\nVmsDeleted: " . $result->getCount() . "\n";

		$this->assertEquals(2, $result->getCount());
	}

    private function prepareDateToSend()
    {
        $dateSent = new DateTime('+1 day', new DateTimeZone('Europe/Warsaw'));
        $dateSent->setTime(14, 0);

        return $dateSent->getTimestamp();
    }
}
