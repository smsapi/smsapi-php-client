<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\Request;

use Fig\Http\Message\RequestMethodInterface;
use Psr\Http\Message\RequestInterface;

class RestRequestBuilder extends RequestBuilder
{
    const QUERY_STRING_SUPPORTED_METHODS = [
        RequestMethodInterface::METHOD_GET,
        RequestMethodInterface::METHOD_DELETE
    ];

    public function get(): RequestInterface
    {
        $uri = $this->uri;

        $formattedParametersString = $this->formattedParametersString();

        if (\in_array($this->method, self::QUERY_STRING_SUPPORTED_METHODS, true)) {
            $uri = $this->uri->withQuery($formattedParametersString);
        }

        $psrRequest = $this->requestFactory->createRequest(
            $this->method,
            $uri
        );

        $psrRequest->withBody(
            $this->streamFactory->createStream(
                $formattedParametersString
            )
        );

        foreach ($this->headers as $name => $values) {
            foreach ($values as $value) {
                $psrRequest = $psrRequest->withAddedHeader($name, $value);
            }
        }

        return $psrRequest;
    }
}
