<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\HttpClient\Decorator;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 */
class BaseUriDecorator implements ClientInterface
{
    private $client;
    private $baseUri;

    public function __construct(ClientInterface $client, string $baseUri)
    {
        $this->client = $client;
        $this->baseUri = $baseUri;
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $request = $this->prependBaseUri($request);

        return $this->client->sendRequest($request);
    }

    private function prependBaseUri(RequestInterface $request): RequestInterface
    {
        $uri = $request->getUri();

        $baseUriParts = parse_url($this->baseUri);

        $scheme = $baseUriParts['scheme'] ?? '';
        $host = $baseUriParts['host'] ?? '';
        $basePath = $baseUriParts['path'] ?? '';
        $basePath = rtrim($basePath, '/');

        $uri = $uri->withPath($basePath . '/' . $uri->getPath());
        $uri = $uri->withHost($host);
        $uri = $uri->withScheme($scheme);

        return $request->withUri($uri);
    }
}