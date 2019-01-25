<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Unit\Feature\Sms\Bag;

use PHPUnit\Framework\TestCase;

abstract class BagWithSingleParamsTestCase extends TestCase
{
    abstract public function createBagWithParams(array $params);

    /**
     * @test
     */
    public function it_should_assign_params()
    {
        $param1 = 'param 1';
        $param3 = 'param 3';
        $params = [
            1 => $param1,
            3 => $param3,
        ];

        $bag = $this->createBagWithParams($params);

        $this->assertObjectHasAttribute('param1', $bag);
        $this->assertObjectNotHasAttribute('param2', $bag);
        $this->assertObjectHasAttribute('param3', $bag);
        $this->assertObjectNotHasAttribute('param4', $bag);
        $this->assertEquals($bag->param1, $param1);
        $this->assertEquals($bag->param3, $param3);
    }
}
