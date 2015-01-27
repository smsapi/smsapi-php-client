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
		$result = null;
		$error = 0;
		$ids = array( );

		$time = time() + 86400;

        $smil = $this->prepareMmsSmil();

        $action = $this->mmsFactory->actionSend();

		/* @var $result \SMSApi\Api\Response\StatusResponse */
		/* @var $item \SMSApi\Api\Response\MessageResponse */

		$result = $action->setSubject("test mms")
                            ->setTo($this->getNumberTest())
                            ->setDateSent($time)
                            ->setSmil($smil)
                            ->execute();

		echo "MmsSend:\n";

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

	public function testGet()
    {
		$result = null;
		$error = 0;

		$action = $this->mmsFactory->actionGet();

		$ids = $this->readIds();

		/* @var $result \SMSApi\Api\Response\StatusResponse */
		/* @var $item \SMSApi\Api\Response\MessageResponse */

		$result = $action->filterByIds($ids)->execute();

		echo "\nMmsGet:\n";

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

		$action = $this->mmsFactory->actionDelete();

		$ids = $this->readIds();

		/* @var $result \SMSApi\Api\Response\CountableResponse */

		$result = $action->filterByIds($ids)->execute();

		echo "\nMmsDelete:\n";
		echo "Delete: " . $result->getCount();

		$this->assertNotEquals( 0, $result->getCount() );
	}
}
