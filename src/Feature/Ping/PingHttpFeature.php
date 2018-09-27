<?php
declare(strict_types=1);

namespace Smsapi\Client\Feature\Ping;

use Fig\Http\Message\RequestMethodInterface;
use Smsapi\Client\Infrastructure\Request\RestRequestBuilderFactory;
use Smsapi\Client\Infrastructure\Response\ApiErrorException;
use Smsapi\Client\Feature\Ping\Data\Ping;
use Smsapi\Client\Infrastructure\RequestExecutor\RestRequestExecutor;
use Smsapi\Client\SmsapiClientException;

/**
 * @internal
 */
class PingHttpFeature implements PingFeature
{
    /**
     * @var RestRequestExecutor
     */
    private $restRequestExecutor;

    /**
     * @var RestRequestBuilderFactory
     */
    private $restRequestBuilderFactory;

    public function __construct(
        RestRequestExecutor $restRequestExecutor,
        RestRequestBuilderFactory $restRequestBuilderFactory
    ) {
        $this->restRequestExecutor = $restRequestExecutor;
        $this->restRequestBuilderFactory = $restRequestBuilderFactory;
    }

    /**
     * @return Ping
     * @throws SmsapiClientException
     */
    public function ping(): Ping
    {
        $ping = new Ping();
        $ping->smsapi = false;
        try {
            $requestBuilder = $this->restRequestBuilderFactory->create();

            $request = $requestBuilder
                ->withMethod(RequestMethodInterface::METHOD_GET)
                ->withPath('')
                ->get();

            $this->restRequestExecutor->execute($request);
        } catch (ApiErrorException $apiErrorException) {
            $ping->smsapi = $apiErrorException->getCode() === 404;
        }

        return $ping;
    }
}
