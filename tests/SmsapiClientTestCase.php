<?php
declare(strict_types=1);

namespace Smsapi\Client\Tests;

use PHPUnit\Framework\TestCase;
use Smsapi\Client\Service\SmsapiComService;
use Smsapi\Client\Service\SmsapiPlService;

class SmsapiClientTestCase extends TestCase
{
    /** @var string */
    protected static $apiToken = '0000000000000000000000000000000000000000';

    /** @var SmsapiPlService|SmsapiComService */
    protected static $smsapiService;
}
