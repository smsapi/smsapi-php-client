<?php

class SmsTest extends SmsapiTestCase
{
    /**
     * @var \SMSApi\Api\SmsFactory
     */
    private $smsFactory;

    protected function setUp()
    {
        $this->smsFactory = new \SMSApi\Api\SmsFactory(null, $this->client());
    }

	public function testSend()
    {
		$result = null;
		$error = 0;
		$ids = array( );

		$time = time() + 86400;

		$action = $this->smsFactory->actionSend();

		/* @var $result \SMSApi\Api\Response\StatusResponse */
		/* @var $item \SMSApi\Api\Response\MessageResponse */

		$result =
			$action
				->setText("test [%1%] message")
				->setTo($this->getNumberTest())
				->SetParam(0, 'asd')
				->setDateSent($time)
				->execute();

		echo "SmsSend:\n";

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

	public function testGet()
    {
		$result = null;
		$error = 0;

		$action = $this->smsFactory->actionGet();

		$ids = $this->readIds();

		/* @var $result \SMSApi\Api\Response\StatusResponse */
		/* @var $item \SMSApi\Api\Response\MessageResponse */

		$result = $action->ids( $ids )->execute();

		echo "\nSmsGet:\n";

		foreach ( $result->getList() as $item ) {
			if ( !$item->getError() ) {
				$this->renderMessageItem( $item );
			} else {
				$error++;
			}
		}

		$this->assertEquals( 0, $error );
	}

	public function testDelete()
    {
		$result = null;

		$action = $this->smsFactory->actionDelete();

		$ids = $this->readIds();

		/* @var $result \SMSApi\Api\Response\CountableResponse */

		$result = $action->ids( $ids )->execute();

		echo "\nSmsDelete:\n";
		echo "Delete: " . $result->getCount();

		$this->assertNotEquals( 0, $result->getCount() );
	}

    public function testTemplate()
    {
        try {
            $result = $this->sendSmsByTemplate();

            $error = 0;

            foreach ($result->getList() as $item) {
                if ($item->getError()) {
                    $error++;
                }
            }

            $this->assertEquals(0, $error);

        } catch (\SMSApi\Exception\ActionException $e) {
            if($e->getCode() == 104) {
                $this->markTestSkipped('Template does not exists.');
            }
        }
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
}