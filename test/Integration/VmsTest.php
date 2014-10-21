<?php

class VmsTest extends SmsapiTestCase
{
	public function testSendAudioFile()
    {
		$smsApi = new \SMSApi\Api\VmsFactory(null, $this->client());

        $time = $this->prepareTimeToSend();

		$audio_file = __DIR__ . DIRECTORY_SEPARATOR . "voice_small.wav";

		$action = $smsApi->actionSend();

		$result =
            $action->setFile($audio_file)
                ->setTo($this->getNumberTest())
                ->setDateSent($time)
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
		$smsApi = new \SMSApi\Api\VmsFactory(null, $this->client());

		$time = $this->prepareTimeToSend();

		$tts = "Wiadomość w formacie TTS";

		$action = $smsApi->actionSend();

		$result = $action->setTts($tts)
			->setTo($this->getNumberTest())
			->setDateSent($time)
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
		$smsApi = new \SMSApi\Api\VmsFactory(null, $this->client());

		$action = $smsApi->actionGet();

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
		$smsApi = new \SMSApi\Api\VmsFactory(null, $this->client());

		$action = $smsApi->actionDelete();

		$ids = array_merge($audioIds, $ttsIds);

		$result = $action->filterByIds($ids)->execute();

		echo "\nVmsDeleted: " . $result->getCount() . "\n";

		$this->assertEquals(2, $result->getCount());
	}

    private function prepareTimeToSend()
    {
        $dateSent = new DateTime('+1 day', new DateTimeZone('Europe/Warsaw'));
        $dateSent->setTime(14, 0);

        return $dateSent->getTimestamp();
    }

    private function countErrors(\SMSApi\Api\Response\StatusResponse $response)
    {
        $errors = 0;

        foreach ($response->getList() as $item) {
            if ($item->getError()) {
                $errors++;
            }
        }

        return $errors;
    }

    private function renderStatusResponse(\SMSApi\Api\Response\StatusResponse $response)
    {
        foreach ($response->getList() as $item) {
            if (!$item->getError()) {
                $this->renderMessageItem($item);
            }
        }
    }

    private function collectIds(\SMSApi\Api\Response\StatusResponse $response)
    {
        $ids = array();

        foreach ($response->getList() as $item) {
            if (!$item->getError()) {
                $ids[] = $item->getId();
            }
        }

        return $ids;
    }
}
