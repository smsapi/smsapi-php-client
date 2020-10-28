<?php

declare(strict_types=1);

namespace Smsapi\Client\Guzzle\Exception;

use Psr\Http\Client\NetworkExceptionInterface;

/**
 * @api
 */
class NetworkException extends ClientException implements NetworkExceptionInterface
{

}