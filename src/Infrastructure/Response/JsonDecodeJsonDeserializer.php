<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\Response;

use Smsapi\Client\Infrastructure\Response\JsonDeserializer;
use Smsapi\Client\Infrastructure\Response\JsonException;

final class JsonDecodeJsonDeserializer implements JsonDeserializer
{
    public function deserialize(string $json): \stdClass
    {
        if (empty($json)) {
            return new \stdClass();
        }

        $decoded = json_decode($json);
        $errorMessage = json_last_error_msg();
        $errorCode = json_last_error();

        if ($errorCode !== JSON_ERROR_NONE) {
            throw new JsonException($errorMessage, $errorCode, $json);
        }

        return $decoded;
    }
}
