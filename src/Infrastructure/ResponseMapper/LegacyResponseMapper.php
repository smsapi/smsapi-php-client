<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\ResponseMapper;

use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;
use Smsapi\Client\Infrastructure\ResponseHttpCode;
use stdClass;

/**
 * @internal
 */
class LegacyResponseMapper
{
    use LoggerAwareTrait;

    private $jsonDecode;

    public function __construct(JsonDecode $jsonDecode)
    {
        $this->logger = new NullLogger();
        $this->jsonDecode = $jsonDecode;
    }

    public function map(ResponseInterface $response): stdClass
    {
        $statusCode = $response->getStatusCode();
        $contents = $response->getBody()->__toString();

        if ($statusCode === ResponseHttpCode::OK) {
            $object = $this->jsonDecode->decode($contents);

            $this->logger->info('Decoded response', ['response' => $object]);

            if (isset($object->message, $object->error)) {
                throw ApiErrorException::withMessageAndError($object->message, $object->error);
            }

            return $object;
        }

        throw ApiErrorException::withStatusCode($statusCode);
    }
}
