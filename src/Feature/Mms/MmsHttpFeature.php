<?php
declare(strict_types=1);

namespace Smsapi\Client\Feature\Mms;

use Smsapi\Client\Feature\Mms\Bag\SendMmsBag;
use Smsapi\Client\Feature\Mms\Data\Mms;
use Smsapi\Client\Feature\Mms\Data\MmsFactory;
use Smsapi\Client\Infrastructure\Request\LegacyRequestBuilderFactory;
use Smsapi\Client\Infrastructure\RequestExecutor\LegacyRequestExecutor;
use Smsapi\Client\SmsapiClientException;

/**
 * @internal
 */
class MmsHttpFeature implements MmsFeature
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
     * @var MmsFactory
     */
    private $mmsFactory;

    public function __construct(
        LegacyRequestExecutor $legacyRequestExecutor,
        LegacyRequestBuilderFactory $legacyRequestBuilderFactory,
        MmsFactory $mmsFactory
    ) {
        $this->legacyRequestExecutor = $legacyRequestExecutor;
        $this->legacyRequestBuilderFactory = $legacyRequestBuilderFactory;
        $this->mmsFactory = $mmsFactory;
    }

    /**
     * @param SendMmsBag $sendMmsBag
     * @return Mms
     * @throws SmsapiClientException
     */
    public function sendMms(SendMmsBag $sendMmsBag): Mms
    {
        $requestBuilder = $this->legacyRequestBuilderFactory->create();

        $request = $requestBuilder
            ->withPath('mms.do')
            ->withBuiltInParameters((array) $sendMmsBag)
            ->get();

        $result = $this->legacyRequestExecutor->execute($request);

        $object = current($result->list);

        return $this->mmsFactory->createFromObject($object);
    }
}
