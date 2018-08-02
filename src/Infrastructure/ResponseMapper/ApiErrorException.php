<?php
declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\ResponseMapper;

use Smsapi\Client\SmsapiClientException;

/**
 * @api
 */
class ApiErrorException extends SmsapiClientException
{
    public static function withMessageErrorAndStatusCode(string $message, string $error, int $statusCode)
    {
        return new self(sprintf('[%s] %s', $error, $message), $statusCode);
    }

    public static function withStatusCode($statusCode)
    {
        return new self('Api error', $statusCode);
    }

    public static function withMessageAndError(string $message, int $error)
    {
        return new self(sprintf('[%u] %s', $error, $message));
    }
}
