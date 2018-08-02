<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Assert;

use PHPUnit\Framework\Assert;
use Smsapi\Client\Feature\Profile\Data\Money;

class MoneyAssert extends Assert
{
    public function assertMoney(Money $money)
    {
        $this->assertGreaterThanOrEqual(0, $money->amount);
        $this->assertNotEmpty($money->currency);
    }
}
