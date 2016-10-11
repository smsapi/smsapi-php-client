<?php
use SMSApi\Api\Response\PointsResponse;
use SMSApi\Api\UserFactory;
use SMSApi\Client;

class TokenTest extends SmsapiTestCase
{
    /**
     * @test
     */
    public function it_should_authorize_by_token()
    {
        $config = self::getConfiguration();
        $client = new Client($config['api_login']);
        $client->setToken($config['api_token']);

        $userFactory = new UserFactory($this->proxy(), $this->client());
        $result = $userFactory->actionGetPoints()->execute();

        $this->assertInstanceOf(PointsResponse::className, $result);
        $this->assertGreaterThanOrEqual(0, $result->getPoints());
    }
}
