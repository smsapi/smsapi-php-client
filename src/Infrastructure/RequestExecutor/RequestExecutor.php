<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\RequestExecutor;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Smsapi\Client\Infrastructure\Response\JsonDeserializer;
use Smsapi\Client\Infrastructure\Request\Mapper\RequestMapper;
use Smsapi\Client\Infrastructure\Response\ResponseValidator;

/**
 * @internal
 */
abstract class RequestExecutor
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var JsonDeserializer
     */
    private $deserializer;

    /**
     * @var ResponseValidator
     */
    private $responseValidator;

    /**
     * @var RequestMapper[]
     */
    private $requestMappers;

    public function __construct(
        ClientInterface $client,
        JsonDeserializer $deserializer,
        ResponseValidator $responseValidator,
        array $requestMappers = []
    ) {
        $this->client = $client;
        $this->deserializer = $deserializer;
        $this->responseValidator = $responseValidator;
        $this->requestMappers = $requestMappers;
    }

    public function execute(RequestInterface $request): \stdClass
    {
        foreach ($this->requestMappers as $mapper) {
            $request = $mapper->map($request);
        }

        $response = $this->client->sendRequest($request);

        $responsePayload = $this->deserializer->deserialize((string) $response->getBody());

        $this->responseValidator->validate($response, $responsePayload);

        return $responsePayload;
    }
}
