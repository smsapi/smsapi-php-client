<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Unit\Feature\Sms\Bag;

use DateTime;
use Smsapi\Client\Feature\Sms\Bag\ScheduleSmssBag;

class ScheduleSmssBagWithSingleParamsTest extends BagWithMultipleParamsTestCase
{
    public function createBagWithParams(array $params)
    {
        return ScheduleSmssBag::withMessage(new DateTime(), ['any'], 'any')->setParams($params);
    }
}
