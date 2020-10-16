<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\Client\Exception;

use Psr\Http\Client\RequestExceptionInterface;

/**
 * @api
 */
class RequestException extends ClientException implements RequestExceptionInterface
{

}