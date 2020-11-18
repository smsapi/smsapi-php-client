<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Unit\Infrastructure\ResponseMapper;

use GuzzleHttp\Psr7\Response;
use Smsapi\Client\Infrastructure\ResponseHttpCode;
use Smsapi\Client\Infrastructure\ResponseMapper\ApiErrorException;
use Smsapi\Client\Infrastructure\ResponseMapper\JsonDecode;
use Smsapi\Client\Infrastructure\ResponseMapper\LegacyResponseMapper;
use Smsapi\Client\Tests\SmsapiClientUnitTestCase;
use stdClass;

class LegacyResponseMapperTest extends SmsapiClientUnitTestCase
{
    /** @var LegacyResponseMapper */
    private $legacyResponseMapper;

    /**
     * @before
     */
    public function given_legacy_response_mapper()
    {
        $this->legacyResponseMapper = new LegacyResponseMapper(new JsonDecode());
    }

    /**
     * @test
     */
    public function it_should_return_decoded_body_on_ok()
    {
        $key = 'any key';
        $value = 'any value';
        $responseWithOkAndBody = $this->createResponse(ResponseHttpCode::OK, $this->createJson($key, $value));

        $result = $this->legacyResponseMapper->map($responseWithOkAndBody);

        $this->assertResult($key, $value, $result);
    }

    /**
     * @test
     */
    public function it_should_return_error_on_ok_with_message_and_error()
    {
        $bodyWithMessageAndError = '{"message":"some message","error":1}';
        $responseWithOkMessageAndError = $this->createResponse(ResponseHttpCode::OK, $bodyWithMessageAndError);

        $this->expectException(ApiErrorException::class);
        $this->legacyResponseMapper->map($responseWithOkMessageAndError);
    }

    /**
     * @test
     */
    public function it_should_throw_exception_on_unrecognized_status()
    {
        $responseWithUnrecognizedStatus = new Response(400);

        $this->expectException(ApiErrorException::class);
        $this->legacyResponseMapper->map($responseWithUnrecognizedStatus);
    }

    private function createJson(string $key, string $value)
    {
        return "{\"{$key}\":\"{$value}\"}";
    }

    private function createResponse(int $code, string $body)
    {
        return new Response($code, [], $body);
    }

    private function assertResult(string $key, string $value, stdClass $result)
    {
        $expected = new stdClass();
        $expected->$key = $value;
        $this->assertEquals($expected, $result);
    }
}
