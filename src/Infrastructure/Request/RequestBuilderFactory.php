<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\Request;

use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

abstract class RequestBuilderFactory
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
     * @var string
     */
    protected $baseUri;

    public function __construct(
        RequestFactoryInterface $requestFactory,
        UriFactoryInterface $uriFactory,
        StreamFactoryInterface $streamFactory,
        string $baseUri
    ) {
        $this->requestFactory = $requestFactory;
        $this->uriFactory = $uriFactory;
        $this->streamFactory = $streamFactory;
        $this->baseUri = $baseUri;
    }

    abstract public function create();
}
