<?php
declare(strict_types=1);

namespace Smsapi\Client\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Smsapi\Client\Feature\Data\DataFactoryProvider;
use Smsapi\Client\Infrastructure\RequestAssembler\GuzzleRequestAssembler;
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

class SmsapiClientUnitTestCase extends SmsapiClientTestCase
{
    /** @var MockHandler */
    private $mockHandler;

    /**
     * @before
     */
    public function prepare()
    {
        $this->mockHandler = new MockHandler();
        $guzzleHttp = new Client(['handler' => HandlerStack::create($this->mockHandler)]);
        $queryFormatter = new ComplexParametersQueryFormatter();
        $jsonDecode = new JsonDecode();

        $requestExecutorFactory = $this->prophesize(RequestExecutorFactory::class);
        $requestExecutorFactory
            ->createLegacyRequestExecutor()
            ->willReturn(
                new LegacyRequestExecutor(
                    new LegacyRequestMapper($queryFormatter),
                    $guzzleHttp,
                    new LegacyResponseMapper($jsonDecode),
                    new GuzzleRequestAssembler()
                )
            );
        $requestExecutorFactory
            ->createRestRequestExecutor()
            ->willReturn(
                new RestRequestExecutor(
                    new RestRequestMapper($queryFormatter),
                    $guzzleHttp,
                    new RestResponseMapper($jsonDecode),
                    new GuzzleRequestAssembler()
                )
            );

        self::$smsapiService = new SmsapiPlHttpService($requestExecutorFactory->reveal(), new DataFactoryProvider());
    }

    protected function mockResponse(int $statusCode, string $body)
    {
        $this->mockHandler->append(new Response($statusCode, [], $body));
    }
}
