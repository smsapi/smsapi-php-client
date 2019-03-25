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
class RestResponseMapper
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

        if (in_array($statusCode, [ResponseHttpCode::OK, ResponseHttpCode::CREATED])) {
            $object = $this->jsonDecode->decode($contents);

            $this->logDecodedResponse($object);

            return $object;
        } elseif (in_array($statusCode, [ResponseHttpCode::ACCEPTED, ResponseHttpCode::NO_CONTENT])) {
            return new stdClass();
        } elseif ($statusCode == ResponseHttpCode::SERVICE_UNAVAILABLE) {
            throw ApiErrorException::withMessageAndStatusCode('Service unavailable', $statusCode);
        } elseif ($contents) {
            $object = $this->jsonDecode->decode($contents);

            $this->logDecodedResponse($object);

            if (isset($object->message, $object->error)) {
                throw ApiErrorException::withMessageErrorAndStatusCode($object->message, $object->error, $statusCode);
            }
        }

        throw ApiErrorException::withStatusCode($statusCode);
    }

    private function logDecodedResponse(stdClass $object)
    {
        $this->logger->info('Decoded response', ['response' => $object]);
    }
}
