<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\RequestAssembler;

use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Smsapi\Client\Infrastructure\Request;

/**
 * @internal
 */
class RequestAssembler
{
    private $requestFactory;
    private $streamFactory;

    public function __construct(RequestFactoryInterface $requestFactory, StreamFactoryInterface $streamFactory)
    {
        $this->requestFactory = $requestFactory;
        $this->streamFactory = $streamFactory;
    }

    public function assemble(Request $requestDTO): RequestInterface
    {
        $request = $this->requestFactory->createRequest(
            $requestDTO->getMethod(),
            $requestDTO->getUri()
        );

        foreach ($requestDTO->getHeaders() as $header => $value) {
            $request = $request->withHeader($header, $value);
        }

        $request = $request->withBody($this->streamFactory->createStream($requestDTO->getBody()));

        return $request;
    }
}
