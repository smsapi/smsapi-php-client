<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\Response;

use Psr\Http\Message\ResponseInterface;
use Smsapi\Client\Infrastructure\Response\ApiErrorException;

interface ResponseValidator
{
    /**
     * @throws ApiErrorException
     *
     * @return void
     */
    public function validate(ResponseInterface $response, \stdClass $deserializedBody);
}