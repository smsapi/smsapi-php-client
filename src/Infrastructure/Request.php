<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure;

/**
 * @internal
 */
class Request
{

    /** @var string */
    private $method;

    /** @var string */
    private $uri;

    /** @var string */
    private $body;

    /** @var array */
    private $headers;

    public function __construct(string $method, string $uri, string $body)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->body = $body;
        $this->headers = [];
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function withHeader(string $headerName, string $headerValue): self
    {
        $this->headers[$headerName] = $headerValue;
        return $this;
    }
}
