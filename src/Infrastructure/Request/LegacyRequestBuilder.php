<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\Request;

use Psr\Http\Message\RequestInterface;

/**
 * @internal
 */
class LegacyRequestBuilder extends RequestBuilder
{
    public function get(): RequestInterface
    {
        $this->builtInParameters['format'] = 'json';

        $psrRequest = $this->requestFactory->createRequest(
            $this->method,
            $this->uri
        );

        $psrRequest->withBody(
            $this->streamFactory->createStream(
                $this->formattedParametersString()
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
