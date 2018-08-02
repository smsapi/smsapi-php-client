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
class RestResponseMapper
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

        if (in_array($statusCode, [ResponseHttpCode::OK, ResponseHttpCode::CREATED])) {
            return $this->jsonDecode->decode($contents);
        } elseif (in_array($statusCode, [ResponseHttpCode::ACCEPTED, ResponseHttpCode::NO_CONTENT])) {
            return new stdClass();
        } elseif ($statusCode == ResponseHttpCode::SERVICE_UNAVAILABLE) {
            throw ApiErrorException::withMessageAndError('Service unavailable', $statusCode);
        } elseif ($contents) {
            $result = $this->jsonDecode->decode($contents);

            if (isset($result->message, $result->error)) {
                throw ApiErrorException::withMessageErrorAndStatusCode($result->message, $result->error, $statusCode);
            }
        }

        throw ApiErrorException::withStatusCode($statusCode);
    }
}
