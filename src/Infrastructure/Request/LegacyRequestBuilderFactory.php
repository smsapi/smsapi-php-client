<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\Request;

final class LegacyRequestBuilderFactory extends RequestBuilderFactory
{
    public function create(): LegacyRequestBuilder
    {
        return new LegacyRequestBuilder(
            $this->baseUri,
            $this->requestFactory,
            $this->uriFactory,
            $this->streamFactory
        );
    }
}
