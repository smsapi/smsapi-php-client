<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Vms;

use Smsapi\Client\Feature\Vms\Bag\SendVmsBag;
use Smsapi\Client\Feature\Vms\Data\Vms;
use Smsapi\Client\Feature\Vms\Data\VmsFactory;
use Smsapi\Client\Infrastructure\RequestExecutor\LegacyRequestExecutor;
use Smsapi\Client\SmsapiClientException;
use stdClass;

/**
 * @internal
 */
class VmsHttpFeature implements VmsFeature
{

    /** @var LegacyRequestExecutor */
    private $legacyRequestExecutor;

    /** @var VmsFactory */
    private $vmsFactory;

    public function __construct(LegacyRequestExecutor $legacyRequestExecutor, VmsFactory $vmsFactory)
    {
        $this->legacyRequestExecutor = $legacyRequestExecutor;
        $this->vmsFactory = $vmsFactory;
    }

    /**
     * @param SendVmsBag $sendVmsBag
     * @return Vms
     * @throws SmsapiClientException
     */
    public function sendVms(SendVmsBag $sendVmsBag): Vms
    {
        return $this->vmsFactory->createFromObject(current($this->makeRequest($sendVmsBag)->list));
    }

    /**
     * @param $data
     * @return stdClass
     * @throws SmsapiClientException
     */
    private function makeRequest($data): stdClass
    {
        return $this->legacyRequestExecutor->request('vms.do', (array)$data);
    }
}
