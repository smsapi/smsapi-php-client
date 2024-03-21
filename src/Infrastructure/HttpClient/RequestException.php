<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\HttpClient;

use Psr\Http\Client\RequestExceptionInterface;

/**
 * @api
 */
class RequestException extends ClientException implements RequestExceptionInterface
{

}