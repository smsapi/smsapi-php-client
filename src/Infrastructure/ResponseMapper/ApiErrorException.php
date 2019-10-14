<?php
declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\ResponseMapper;

use Smsapi\Client\SmsapiClientException;

/**
 * @api
 */
class ApiErrorException extends SmsapiClientException
{
    /** @var string */
    private $error = '';

    public static function withMessageErrorAndStatusCode(string $message, string $error, int $statusCode): self
    {
        $exception = new self($message, $statusCode);
        $exception->error = $error;

        return $exception;
    }

    public static function withStatusCode($statusCode): self
    {
        return new self('Api error', $statusCode);
    }

    public static function withMessageAndError(string $message, int $error): self
    {
        $exception = new self($message);
        $exception->error = (string)$error;

        return $exception;
    }

    public static function withMessageAndStatusCode(string $message, int $statusCode): self
    {
        return new self($message, $statusCode);
    }

    public function getError(): string
    {
        return $this->error;
    }
}
