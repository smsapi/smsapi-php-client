<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Helper\HttpClient\Exception;

use Psr\Http\Client\RequestExceptionInterface;

/**
 * @api
 */
class RequestException extends ClientException implements RequestExceptionInterface
{

}