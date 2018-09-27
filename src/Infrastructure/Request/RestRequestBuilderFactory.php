<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\Request;

final class RestRequestBuilderFactory extends RequestBuilderFactory
{
    public function create(): RestRequestBuilder
    {
        return new RestRequestBuilder(
            $this->baseUri,
            $this->requestFactory,
            $this->uriFactory,
            $this->streamFactory
        );
    }
}
