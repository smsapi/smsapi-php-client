<?php
declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\ResponseMapper;

use Psr\Http\Message\ResponseInterface;
use Smsapi\Client\Infrastructure\ResponseHttpCode;
use Smsapi\Client\SmsapiClientException;
use stdClass;

/**
 * @internal
 */
class LegacyResponseMapper
{
    private $jsonDecode;

    public function __construct(JsonDecode $jsonDecode)
    {
        $this->jsonDecode = $jsonDecode;
    }

    /**
     * @param ResponseInterface $response
     * @return stdClass
     * @throws SmsapiClientException
     */
    public function map(ResponseInterface $response): stdClass
    {
        $statusCode = $response->getStatusCode();
        $contents = $response->getBody()->getContents();

        if ($statusCode === ResponseHttpCode::OK) {
            $result = $this->jsonDecode->decode($contents);

            if (isset($result->message, $result->error)) {
                throw ApiErrorException::withMessageAndError($result->message, $result->error);
            }

            return $result;
        }

        throw ApiErrorException::withStatusCode($statusCode);
    }
}
