<?php

declare(strict_types=1);

namespace Smsapi\Client\Curl\Exception;

use Smsapi\Client\Infrastructure\HttpClient\ClientException as HttpClientException;

/**
 * @api
 * @deprecated
 * @see HttpClientException
 */
class ClientException extends HttpClientException
{

}