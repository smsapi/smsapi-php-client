<?php

declare(strict_types=1);

namespace Smsapi\Client\Curl\Exception;

use Psr\Http\Client\RequestExceptionInterface;

/**
 * @api
 */
class RequestException extends ClientException implements RequestExceptionInterface
{

}