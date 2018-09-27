<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\Response;

use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Smsapi\Client\Infrastructure\Response\ResponseValidator;
use Smsapi\Client\Infrastructure\Response\ApiErrorException;

final class RestResponseValidator implements ResponseValidator
{
    const ALLOWED_STATUSES = [
        StatusCodeInterface::STATUS_OK,
        StatusCodeInterface::STATUS_CREATED,
        StatusCodeInterface::STATUS_ACCEPTED,
        StatusCodeInterface::STATUS_NO_CONTENT
    ];

    public function validate(ResponseInterface $response, \stdClass $deserializedBody)
    {
        $statusCode = $response->getStatusCode();

        if (!\in_array($statusCode, self::ALLOWED_STATUSES, true)) {
            if ($statusCode === StatusCodeInterface::STATUS_SERVICE_UNAVAILABLE) {
                throw ApiErrorException::withMessageAndError('Service unavailable', $statusCode);
            }

            if (isset($deserializedBody->message, $deserializedBody->error)) {
                throw ApiErrorException::withMessageErrorAndStatusCode($deserializedBody->message, $deserializedBody->error, $statusCode);
            }

            throw ApiErrorException::withStatusCode($statusCode);
        }
    }
}
