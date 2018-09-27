<?php
declare(strict_types=1);

namespace Smsapi\Client\Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Http\Adapter\Guzzle6\Client;
use Http\Factory\Guzzle\RequestFactory;
use Http\Factory\Guzzle\StreamFactory;
use Http\Factory\Guzzle\UriFactory;
use Smsapi\Client\Feature\Data\DataFactoryProvider;
use Smsapi\Client\Infrastructure\Request\LegacyRequestBuilderFactory;
use Smsapi\Client\Infrastructure\Request\RequestBuilderFactory;
use Smsapi\Client\Infrastructure\Request\RestRequestBuilderFactory;
use Smsapi\Client\Infrastructure\RequestExecutor\LegacyRequestExecutor;
use Smsapi\Client\Infrastructure\RequestExecutor\RequestExecutor;
use Smsapi\Client\Infrastructure\RequestExecutor\RequestExecutorFactory;
use Smsapi\Client\Infrastructure\RequestExecutor\RestRequestExecutor;
use Smsapi\Client\Infrastructure\Response\JsonDecodeJsonDeserializer;
use Smsapi\Client\Infrastructure\Response\LegacyResponseValidator;
use Smsapi\Client\Infrastructure\Response\RestResponseValidator;
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
        $client = new Client(
            new \GuzzleHttp\Client(['handler' => HandlerStack::create($this->mockHandler)])
        );

        $requestExecutorFactory = $this->prophesize(RequestExecutorFactory::class);
        $requestExecutorFactory
            ->createLegacyRequestExecutor()
            ->willReturn(
                new LegacyRequestExecutor(
                    $client,
                    new JsonDecodeJsonDeserializer(),
                    new LegacyResponseValidator(),
                    self::$apiToken
                )
            );
        $requestExecutorFactory
            ->createRestRequestExecutor()
            ->willReturn(
                new RestRequestExecutor(
                    $client,
                    new JsonDecodeJsonDeserializer(),
                    new RestResponseValidator(),
                    self::$apiToken
                )
            );

        $requestFactory = new RequestFactory();
        $uriFactory = new UriFactory();
        $streamFactory = new StreamFactory();

        self::$smsapiService = new SmsapiPlHttpService(
            $requestExecutorFactory->reveal(),
            new RestRequestBuilderFactory(
                $requestFactory,
                $uriFactory,
                $streamFactory,
                'http://example.com/'
            ),
            new LegacyRequestBuilderFactory(
                $requestFactory,
                $uriFactory,
                $streamFactory,
                'http://example.com/'
            ),
            new DataFactoryProvider()
        );
    }

    protected function mockResponse(int $statusCode, string $body)
    {
        $this->mockHandler->append(new Response($statusCode, [], $body));
    }
}
