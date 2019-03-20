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
    private $tag;

    public static function withMessageTagAndStatusCode(string $message, string $tag, int $statusCode): self
    {
        $exception = new self($message, $statusCode);
        $exception->tag = $tag;

        return $exception;
    }

    public static function withStatusCode($statusCode): self
    {
        return new self('Api error', $statusCode);
    }

    public static function withMessageAndTag(string $message, int $tag): self
    {
        $exception = new self($message);
        $exception->tag = (string)$tag;

        return $exception;
    }

    public static function withMessageAndStatusCode(string $message, int $statusCode): self
    {
        return new self($message, $statusCode);
    }

    public function getTag(): string
    {
        return $this->tag;
    }
}
