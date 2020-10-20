<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\HttpClient\Decorator;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 */
class CorrelationIdHeaderDecorator implements ClientInterface
{
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $request = $this->addXRequestIdHeader($request);

        return $this->client->sendRequest($request);
    }

    private function addXRequestIdHeader(RequestInterface $request): RequestInterface
    {
        return $request->withHeader('X-Request-Id', $this->generateRequestId());
    }

    private function generateRequestId(): string
    {
        return bin2hex(random_bytes(12));
    }
}