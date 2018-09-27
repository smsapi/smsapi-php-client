<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\Response;

use JsonException;

interface JsonDeserializer
{
    /**
     * @throws JsonException
     */
    public function deserialize(string $json): \stdClass;
}
