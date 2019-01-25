<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Unit\Feature\Sms\Bag;

use DateTime;
use Smsapi\Client\Feature\Sms\Bag\ScheduleSmsBag;

class ScheduleSmsBagWithParamsTest extends BagWithSingleParamsTestCase
{
    public function createBagWithParams(array $params)
    {
        return ScheduleSmsBag::withMessage(new DateTime(), 'any', 'any')->setParams($params);
    }
}
