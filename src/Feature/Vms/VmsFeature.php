<?php
declare(strict_types=1);

namespace Smsapi\Client\Feature\Vms;

use Smsapi\Client\Feature\Vms\Bag\SendVmsBag;
use Smsapi\Client\Feature\Vms\Data\Vms;

/**
 * @api
 */
interface VmsFeature
{

    /**
     * @param SendVmsBag $sendVmsBag
     * @return Vms
     */
    public function sendVms(SendVmsBag $sendVmsBag): Vms;
}
