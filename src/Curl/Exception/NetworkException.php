<?php

declare(strict_types=1);

namespace Smsapi\Client\Curl\Exception;

use Psr\Http\Client\NetworkExceptionInterface;

/**
 * @api
 */
class NetworkException extends ClientException implements NetworkExceptionInterface
{

}