<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\Response;

use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Smsapi\Client\Infrastructure\Response\ResponseValidator;
use Smsapi\Client\Infrastructure\Response\ApiErrorException;

final class LegacyResponseValidator implements ResponseValidator
{
    public function validate(ResponseInterface $response, \stdClass $deserializedBody)
    {
        $statusCode = $response->getStatusCode();

        if ($statusCode !== StatusCodeInterface::STATUS_OK) {
            throw ApiErrorException::withStatusCode($statusCode);
        }

        if (isset($deserializedBody->message, $deserializedBody->error)) {
            throw ApiErrorException::withMessageAndError($deserializedBody->message, $deserializedBody->error);
        }
    }
}
