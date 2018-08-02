<?php
declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\ResponseMapper;

use Smsapi\Client\SmsapiClientException;

/**
 * @api
 */
class JsonException extends SmsapiClientException
{
    private $json;

    public function __construct(string $message, int $code, string $json)
    {
        parent::__construct($message, $code);

        $this->json = $json;
    }

    public function getJson(): string
    {
        return $this->json;
    }
}
