<?php

declare(strict_types=1);

namespace Smsapi\Client\Curl\Exception;

use Smsapi\Client\Infrastructure\HttpClient\NetworkException as HttpClientNetworkException;

/**
 * @api
 * @deprecated
 * @see HttpClientNetworkException
 */
class NetworkException extends HttpClientNetworkException
{

}