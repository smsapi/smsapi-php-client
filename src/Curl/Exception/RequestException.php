<?php

declare(strict_types=1);

namespace Smsapi\Client\Curl\Exception;

use Smsapi\Client\Infrastructure\HttpClient\RequestException as HttpClientRequestException;

/**
 * @api
 * @deprecated
 * @see HttpClientRequestException
 */
class RequestException extends HttpClientRequestException
{

}