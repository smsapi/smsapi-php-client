<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\HttpClient\Decorator;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * @internal
 */
class LoggerDecorator implements ClientInterface
{
    private $client;
    private $logger;

    public function __construct(ClientInterface $client, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->logger = $logger;
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $this->logger->info('Request', [
            'method' => $request->getMethod(),
            'uri' => $request->getUri(),
        ]);

        $response = $this->client->sendRequest($request);

        $this->logger->info('Response', ['response' => $response]);

        return $response;
    }
}
