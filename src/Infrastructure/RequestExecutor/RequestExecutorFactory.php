<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\RequestExecutor;

use Psr\Http\Client\ClientInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Smsapi\Client\Infrastructure\Response\JsonDecodeJsonDeserializer;
use Smsapi\Client\Infrastructure\Response\LegacyResponseValidator;
use Smsapi\Client\Infrastructure\Response\RestResponseValidator;

/**
 * @internal
 */
class RequestExecutorFactory
{
    use LoggerAwareTrait;

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $baseUri;

    public function __construct(ClientInterface $client, string $token, LoggerInterface $logger = null)
    {
        $this->client = $client;
        $this->token = $token;
        $this->logger = $logger ?? new NullLogger();
    }

    public function createRestRequestExecutor(): RestRequestExecutor
    {
        $client = new ClientLoggerDecorator($this->client, $this->logger);

        return new RestRequestExecutor(
            $client,
            new JsonDecodeJsonDeserializer(),
            new RestResponseValidator(),
            $this->token
        );
    }

    public function createLegacyRequestExecutor(): LegacyRequestExecutor
    {
        $client = new ClientLoggerDecorator($this->client, $this->logger);

        return new LegacyRequestExecutor(
            $client,
            new JsonDecodeJsonDeserializer(),
            new LegacyResponseValidator(),
            $this->token
        );
    }
}
