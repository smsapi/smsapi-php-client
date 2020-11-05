<?php
declare(strict_types=1);

namespace Smsapi\Client\Tests;

use Smsapi\Client\Feature\Data\DataFactoryProvider;
use Smsapi\Client\Curl\RequestFactory;
use Smsapi\Client\Curl\StreamFactory;
use Smsapi\Client\Infrastructure\RequestExecutor\LegacyRequestExecutor;
use Smsapi\Client\Infrastructure\RequestExecutor\RequestExecutorFactory;
use Smsapi\Client\Infrastructure\RequestExecutor\RestRequestExecutor;
use Smsapi\Client\Infrastructure\RequestMapper\LegacyRequestMapper;
use Smsapi\Client\Infrastructure\RequestMapper\Query\Formatter\ComplexParametersQueryFormatter;
use Smsapi\Client\Infrastructure\RequestMapper\RestRequestMapper;
use Smsapi\Client\Infrastructure\ResponseMapper\JsonDecode;
use Smsapi\Client\Infrastructure\ResponseMapper\LegacyResponseMapper;
use Smsapi\Client\Infrastructure\ResponseMapper\RestResponseMapper;
use Smsapi\Client\Service\SmsapiPlHttpService;
use Smsapi\Client\Tests\Helper\HttpClient\HttpClientMock;

class SmsapiClientUnitTestCase extends SmsapiClientTestCase
{
    /** @var HttpClientMock */
    private $httpClient;

    /**
     * @before
     */
    public function prepare()
    {
        $this->httpClient = new HttpClientMock();
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();

        $queryFormatter = new ComplexParametersQueryFormatter();
        $jsonDecode = new JsonDecode();

        /** @var RequestExecutorFactory $requestExecutorFactory */
        $requestExecutorFactory = $this->prophesize(RequestExecutorFactory::class);
        $requestExecutorFactory
            ->createLegacyRequestExecutor($this->httpClient)
            ->willReturn(
                new LegacyRequestExecutor(
                    new LegacyRequestMapper($queryFormatter),
                    $this->httpClient,
                    new LegacyResponseMapper($jsonDecode),
                    $requestFactory,
                    $streamFactory
                )
            );
        $requestExecutorFactory
            ->createRestRequestExecutor($this->httpClient)
            ->willReturn(
                new RestRequestExecutor(
                    new RestRequestMapper($queryFormatter),
                    $this->httpClient,
                    new RestResponseMapper($jsonDecode),
                    $requestFactory,
                    $streamFactory
                )
            );

        self::$smsapiService = new SmsapiPlHttpService(
            $this->httpClient,
            $requestExecutorFactory->reveal(),
            new DataFactoryProvider()
        );
    }

    protected function mockResponse(int $statusCode, string $body)
    {
        $this->httpClient->mockResponse($statusCode, $body);
    }
}
