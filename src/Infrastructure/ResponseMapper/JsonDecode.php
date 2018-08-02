<?php
declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\ResponseMapper;

use stdClass;

/**
 * @internal
 */
class JsonDecode
{
    /**
     * @param string $json
     * @return stdClass
     * @throws JsonException
     */
    public function decode(string $json): stdClass
    {
        $decoded = json_decode($json);
        $errorMessage = json_last_error_msg();
        $errorCode = json_last_error();

        if ($errorCode !== JSON_ERROR_NONE) {
            throw new JsonException($errorMessage, $errorCode, $json);
        }

        return $decoded;
    }
}
