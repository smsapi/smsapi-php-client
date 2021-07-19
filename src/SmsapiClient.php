<?php
declare(strict_types=1);

namespace Smsapi\Client;

use Psr\Log\LoggerAwareInterface;
use Smsapi\Client\Service\SmsapiComService;
use Smsapi\Client\Service\SmsapiPlService;

/**
 * @api
 */
interface SmsapiClient extends LoggerAwareInterface
{
    const VERSION = 'Unreleased';

    public function smsapiPlService(string $apiToken): SmsapiPlService;

    public function smsapiPlServiceWithUri(string $apiToken, string $uri): SmsapiPlService;

    public function smsapiComService(string $apiToken): SmsapiComService;

    public function smsapiComServiceWithUri(string $apiToken, string $uri): SmsapiComService;
}
