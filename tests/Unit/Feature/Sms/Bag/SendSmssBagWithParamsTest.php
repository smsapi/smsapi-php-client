<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Unit\Feature\Sms\Bag;

use Smsapi\Client\Feature\Sms\Bag\SendSmssBag;

class SendSmssBagWithParamsTest extends BagWithMultipleParamsTestCase
{
    public function createBagWithParams(array $params)
    {
        return SendSmssBag::withMessage(['any'], 'any')->setParams($params);
    }
}
