<?php

class SenderTest extends SmsapiTestCase
{
    /**
     * @var \SMSApi\Api\SenderFactory
     */
    private $senderFactory;

	private $senderTest = "Olek";

    protected function setUp()
    {
        $this->senderFactory = new \SMSApi\Api\SenderFactory($this->proxy, $this->client());
    }

	private function renderSenderItem( $item ) {

		if ( $item ) {
			print("Sendername: " . $item->getName()
				. " Status: " . $item->getStatus()
				. " Default:" . $item->isDefault()
				. "\n" );
		} else {
			print("Item is null\n" );
		}
	}

	public function testAdd()
    {
		$result = null;

		$action = $this->senderFactory->actionAdd($this->senderTest);

		$result = $action->execute();

		/* @var $item \SMSApi\Api\Response\CountableResponse */

		print("\nSenderAdd: " . $result->getCount() . "\n" );

		$this->assertNotEquals( 0, $result->getCount() );
	}

	public function testList()
    {
		$result = null;
		$error = 0;

		$action = $this->senderFactory->actionList();

		/* @var $result \SMSApi\Api\Response\SendersResponse */
		/* @var $item \SMSApi\Api\Response\SenderResponse */

		$result = $action->execute();

		echo "\nSenderList:\n";

		if ( empty( $result ) ) {
			$error++;
		}

		foreach ( $result->getList() as $item ) {
			$this->renderSenderItem( $item );
		}

		$this->assertEquals( 0, $error );
	}

	public function testDelete()
    {
		$result = null;

		$action = $this->senderFactory->actionDelete($this->senderTest);

		$result = $action->execute();

		/* @var $result \SMSApi\Api\Response\CountableResponse */

		print("\nSenderDelete: " . $result->getCount() );

		$this->assertNotEquals( 0, $result->getCount() );
	}
}
