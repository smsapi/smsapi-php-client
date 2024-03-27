<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\HttpClient;

use Psr\Http\Client\NetworkExceptionInterface;

/**
 * @api
 */
class NetworkException extends ClientException implements NetworkExceptionInterface
{

}