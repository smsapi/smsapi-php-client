<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Unit\Feature\Sms\Bag;

use Smsapi\Client\Feature\Sms\Bag\SendSmsBag;

class SendSmsBagWithSingleParamsTest extends BagWithSingleParamsTestCase
{
    public function createBagWithParams(array $params)
    {
        return SendSmsBag::withMessage('any', 'any')->setParams($params);
    }
}
