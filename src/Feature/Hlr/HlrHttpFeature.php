<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Hlr;

use Smsapi\Client\Feature\Hlr\Bag\SendHlrBag;
use Smsapi\Client\Feature\Hlr\Data\Hlr;
use Smsapi\Client\Feature\Hlr\Data\HlrFactory;
use Smsapi\Client\Infrastructure\Request\LegacyRequestBuilderFactory;
use Smsapi\Client\Infrastructure\RequestExecutor\LegacyRequestExecutor;
use Smsapi\Client\SmsapiClientException;
use stdClass;

/**
 * @internal
 */
class HlrHttpFeature implements HlrFeature
{
    /**
     * @var LegacyRequestExecutor
     */
    private $legacyRequestExecutor;

    /**
     * @var LegacyRequestBuilderFactory
     */
    private $legacyRequestBuilderFactory;

    /**
     * @var HlrFactory
     */
    private $hlrFactory;

    public function __construct(
        LegacyRequestExecutor $legacyRequestExecutor,
        LegacyRequestBuilderFactory $legacyRequestBuilderFactory,
        HlrFactory $hlrFactory
    ) {
        $this->legacyRequestExecutor = $legacyRequestExecutor;
        $this->legacyRequestBuilderFactory = $legacyRequestBuilderFactory;
        $this->hlrFactory = $hlrFactory;
    }

    /**
     * @param SendHlrBag $sendHlrBag
     * @return Hlr
     * @throws SmsapiClientException
     */
    public function sendHlr(SendHlrBag $sendHlrBag): Hlr
    {
        return $this->hlrFactory->createFromObject($this->makeRequest($sendHlrBag));
    }

    /**
     * @param object $data
     * @return stdClass
     * @throws SmsapiClientException
     */
    private function makeRequest($data): stdClass
    {
        $requestBuilder = $this->legacyRequestBuilderFactory->create();

        $request = $requestBuilder
            ->withPath('hlr.do')
            ->withBuiltInParameters((array) $data)
            ->get();

        return $this->legacyRequestExecutor->execute($request);
    }
}
