<?php
declare(strict_types=1);

namespace Smsapi\Client\Feature\Mms;

use Smsapi\Client\Feature\Mms\Bag\SendMmsBag;
use Smsapi\Client\Feature\Mms\Data\Mms;

/**
 * @api
 */
interface MmsFeature
{
    public function sendMms(SendMmsBag $sendMmsBag): Mms;
}
