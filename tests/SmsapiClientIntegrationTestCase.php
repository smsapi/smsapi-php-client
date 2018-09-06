<?php
declare(strict_types=1);

namespace Smsapi\Client\Tests;

use RuntimeException;
use Smsapi\Client\Service\SmsapiComService;
use Smsapi\Client\Service\SmsapiPlService;
use Smsapi\Client\SmsapiHttpClient;

class SmsapiClientIntegrationTestCase extends SmsapiClientTestCase
{
    /**
     * @beforeClass
     */
    public static function prepare()
    {
        self::$apiToken = Config::get('API token');

        if (self::$apiToken === null) {
            self::markTestSkipped('Missing API token - create "tests-resources/config/config.yml"');
        }

        if (!is_string(self::$apiToken)) {
            throw new RuntimeException('Invalid API token');
        }

        $apiUri = Config::get('API URI');

        if (!filter_var($apiUri, FILTER_VALIDATE_URL)) {
            throw new RuntimeException('Invalid API URI');
        }

        $smsapiHttpClient = new SmsapiHttpClient();

        if (Config::get('logger')) {
            $smsapiHttpClient->setLogger(new TestLogger());
        }

        if (Config::getServiceName()->is(ServiceName::SMSAPI_PL)) {
            self::$smsapiService = $smsapiHttpClient->smsapiPlServiceWithUri(self::$apiToken, $apiUri);
        } elseif (Config::getServiceName()->is(ServiceName::SMSAPI_COM)) {
            self::$smsapiService = $smsapiHttpClient->smsapiComServiceWithUri(self::$apiToken, $apiUri);
        }
    }

    protected static function skipIfServiceIsNotCom()
    {
        if (!(self::$smsapiService instanceof SmsapiComService)) {
            self::markTestSkipped('Feature available for COM service only.');
        }
    }

    protected static function skipIfServiceIsNotPl()
    {
        if (!(self::$smsapiService instanceof SmsapiPlService)) {
            self::markTestSkipped('Feature available for PL service only.');
        }
    }
}
