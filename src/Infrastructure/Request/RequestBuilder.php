<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\Request;

use Fig\Http\Message\RequestMethodInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;
use Smsapi\Client\Infrastructure\Request\Query\Formatter\ComplexParametersQueryFormatter;
use Smsapi\Client\Infrastructure\Request\Query\QueryParametersData;

/**
 * @internal
 */
abstract class RequestBuilder
{
    /**
     * @var RequestFactoryInterface
     */
    protected $requestFactory;

    /**
     * @var UriFactoryInterface
     */
    protected $uriFactory;

    /**
     * @var StreamFactoryInterface
     */
    protected $streamFactory;

    /**
     * @var null|string
     */
    protected $method;

    /**
     * @var UriInterface
     */
    protected $uri;

    /**
     * @var array<string,string>
     */
    protected $headers;

    /**
     * @var StreamInterface
     */
    protected $body;

    /**
     * @var array
     */
    protected $builtInParameters;

    /**
     * @var array
     */
    protected $userParameters;

    /**
     * @var ComplexParametersQueryFormatter
     */
    protected $formatter;

    public function __construct(
        string $baseUri,
        RequestFactoryInterface $requestFactory,
        UriFactoryInterface $uriFactory,
        StreamFactoryInterface $streamFactory
    ) {
        $this->requestFactory = $requestFactory;
        $this->uriFactory = $uriFactory;
        $this->streamFactory = $streamFactory;

        $this->method = RequestMethodInterface::METHOD_GET;
        $this->uri = $this->uriFactory->createUri($baseUri);
        $this->headers = [];
        $this->body = $this->streamFactory->createStream();

        $this->formatter = new ComplexParametersQueryFormatter();

        $this->builtInParameters = [];
        $this->userParameters = [];
    }

    public function withMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    public function withPath(string $uri): self
    {
        $this->uri = $this->uri->withPath($uri);

        return $this;
    }

    public function withBuiltInParameters(array $parameters): self
    {
        $this->builtInParameters = $parameters;

        return $this;
    }

    public function withUserParameters(array $parameters): self
    {
        $this->userParameters = $parameters;

        return $this;
    }

    public function withHeaders(array $headers): self
    {
        $this->headers = $headers;

        return $this;
    }

    abstract public function get(): RequestInterface;

    protected function withAddedHeaders(RequestInterface $request): RequestInterface
    {
        foreach ($this->headers as $name => $values) {
            foreach ($values as $value) {
                $request = $request->withAddedHeader($name, $value);
            }
        }

        return $request;
    }

    protected function formattedParametersString(): string
    {
        return $this->formatter->format(
            new QueryParametersData($this->builtInParameters, $this->userParameters)
        );
    }
}
